# KidsLearn Deployment Guide

Step-by-step guide to deploy KidsLearn to production.

## 📋 Pre-Deployment Checklist

- [ ] All tests passing locally
- [ ] Database migrations completed
- [ ] Database seeded with initial data
- [ ] Environment variables configured
- [ ] Build successful (`npm run build`)
- [ ] No console errors in production build
- [ ] Supabase project in production mode

---

## 🚀 Deployment Options

### Option 1: Vercel (Recommended - Easiest)

#### Setup Steps

1. **Prepare Repository**

   ```bash
   git init
   git add .
   git commit -m "Initial commit - KidsLearn app"
   git branch -M main
   git remote add origin https://github.com/yourusername/kidslearn.git
   git push -u origin main
   ```

2. **Deploy to Vercel**

   - Visit [vercel.com](https://vercel.com)
   - Click "New Project"
   - Import your GitHub repository
   - Configure project:
     - Framework Preset: Next.js
     - Root Directory: ./
     - Build Command: `npm run build`
     - Output Directory: (leave default)

3. **Add Environment Variables**
   In Vercel dashboard, add these variables:

   ```
   NEXT_PUBLIC_SUPABASE_URL=your-project-url.supabase.co
   NEXT_PUBLIC_SUPABASE_ANON_KEY=your-anon-key
   SUPABASE_SERVICE_ROLE_KEY=your-service-role-key
   NEXT_PUBLIC_APP_NAME=KidsLearn
   NEXT_PUBLIC_APP_URL=https://your-app.vercel.app
   ```

4. **Deploy**
   - Click "Deploy"
   - Wait for build to complete (~2-3 minutes)
   - Visit your deployed site!

#### Automatic Deployments

Every push to `main` branch automatically deploys to production.

---

### Option 2: Netlify

#### Setup Steps

1. **Install Netlify CLI**

   ```bash
   npm install -g netlify-cli
   ```

2. **Login to Netlify**

   ```bash
   netlify login
   ```

3. **Build the Project**

   ```bash
   npm run build
   ```

4. **Initialize Netlify**

   ```bash
   netlify init
   ```

   Choose:

   - Create & configure a new site
   - Team: Your team
   - Site name: kidslearn (or your choice)
   - Build command: `npm run build`
   - Publish directory: `.next`

5. **Add Environment Variables**

   ```bash
   netlify env:set NEXT_PUBLIC_SUPABASE_URL "your-url"
   netlify env:set NEXT_PUBLIC_SUPABASE_ANON_KEY "your-key"
   netlify env:set SUPABASE_SERVICE_ROLE_KEY "your-key"
   ```

6. **Deploy**
   ```bash
   netlify deploy --prod
   ```

---

### Option 3: Self-Hosted (VPS/Cloud)

#### Requirements

- Ubuntu 20.04+ server
- Node.js 18+
- Nginx
- PM2 (process manager)
- Domain name (optional)

#### Setup Steps

1. **Server Setup**

   ```bash
   # Update system
   sudo apt update && sudo apt upgrade -y

   # Install Node.js
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt install -y nodejs

   # Install PM2
   sudo npm install -g pm2

   # Install Nginx
   sudo apt install -y nginx
   ```

2. **Upload Project**

   ```bash
   # On your local machine
   rsync -avz --exclude node_modules --exclude .next \
     ./ user@your-server:/var/www/kidslearn/
   ```

3. **Build on Server**

   ```bash
   ssh user@your-server
   cd /var/www/kidslearn
   npm install
   npm run build
   ```

4. **Configure Environment**

   ```bash
   nano .env.local
   # Add your environment variables
   ```

5. **Start with PM2**

   ```bash
   pm2 start npm --name "kidslearn" -- start
   pm2 startup
   pm2 save
   ```

6. **Configure Nginx**

   ```bash
   sudo nano /etc/nginx/sites-available/kidslearn
   ```

   Add:

   ```nginx
   server {
       listen 80;
       server_name your-domain.com;

       location / {
           proxy_pass http://localhost:3000;
           proxy_http_version 1.1;
           proxy_set_header Upgrade $http_upgrade;
           proxy_set_header Connection 'upgrade';
           proxy_set_header Host $host;
           proxy_cache_bypass $http_upgrade;
       }
   }
   ```

   Enable site:

   ```bash
   sudo ln -s /etc/nginx/sites-available/kidslearn /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   ```

7. **SSL Certificate (Optional)**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com
   ```

---

## 🗄️ Database Production Setup

### Supabase Production Checklist

1. **Security Settings**

   - [ ] Enable Row Level Security on all tables
   - [ ] Review and test all RLS policies
   - [ ] Remove test data
   - [ ] Set up database backups

2. **Performance**

   - [ ] Add necessary indexes
   - [ ] Optimize slow queries
   - [ ] Enable connection pooling

3. **Monitoring**
   - [ ] Set up usage alerts
   - [ ] Monitor API requests
   - [ ] Track error rates

### Backup Strategy

```sql
-- Manual backup (run in Supabase SQL Editor)
-- Export tables to JSON
SELECT json_agg(row_to_json(t)) FROM users t;
SELECT json_agg(row_to_json(t)) FROM animals t;
SELECT json_agg(row_to_json(t)) FROM quiz_questions t;
```

---

## 🔒 Security Best Practices

### 1. Environment Variables

✅ **DO:**

- Use `.env.local` for sensitive data
- Never commit `.env.local` to git
- Use different keys for dev/prod

❌ **DON'T:**

- Hardcode API keys in code
- Share service role key publicly
- Use same credentials across environments

### 2. API Security

```typescript
// Rate limiting example
const MAX_REQUESTS = 100;
const WINDOW_MS = 15 * 60 * 1000; // 15 minutes

// Implement in API routes
```

### 3. Authentication

- Use bcrypt for password hashing (already implemented)
- Implement session timeout
- Add 2FA for admin accounts (future)

---

## 📊 Monitoring & Analytics

### Vercel Analytics

```bash
npm install @vercel/analytics
```

```typescript
// Add to app/layout.tsx
import { Analytics } from "@vercel/analytics/react";

export default function RootLayout({ children }) {
  return (
    <html>
      <body>
        {children}
        <Analytics />
      </body>
    </html>
  );
}
```

### Error Tracking (Sentry)

```bash
npm install @sentry/nextjs
```

```javascript
// sentry.config.js
Sentry.init({
  dsn: process.env.SENTRY_DSN,
  environment: process.env.NODE_ENV,
});
```

---

## 🔄 CI/CD Pipeline

### GitHub Actions Example

Create `.github/workflows/deploy.yml`:

```yaml
name: Deploy to Production

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v2

      - name: Setup Node.js
        uses: actions/setup-node@v2
        with:
          node-version: "18"

      - name: Install dependencies
        run: npm ci

      - name: Run tests
        run: npm test

      - name: Build
        run: npm run build
        env:
          NEXT_PUBLIC_SUPABASE_URL: ${{ secrets.SUPABASE_URL }}
          NEXT_PUBLIC_SUPABASE_ANON_KEY: ${{ secrets.SUPABASE_ANON_KEY }}

      - name: Deploy to Vercel
        uses: amondnet/vercel-action@v20
        with:
          vercel-token: ${{ secrets.VERCEL_TOKEN }}
          vercel-org-id: ${{ secrets.ORG_ID }}
          vercel-project-id: ${{ secrets.PROJECT_ID }}
          vercel-args: "--prod"
```

---

## 🧪 Post-Deployment Testing

### Smoke Tests

```bash
# Test endpoints
curl https://your-app.vercel.app
curl https://your-app.vercel.app/api/health

# Test authentication
# Visit /login and create test account

# Test learning modules
# Navigate through all categories

# Test mini games
# Complete a quiz
```

### Performance Testing

- Use [Lighthouse](https://developers.google.com/web/tools/lighthouse)
- Check Core Web Vitals
- Test on mobile devices
- Verify loading times < 3 seconds

---

## 🐛 Troubleshooting

### Build Failures

**Error: "Module not found"**

```bash
# Clear cache and rebuild
rm -rf .next node_modules
npm install
npm run build
```

**Error: "Environment variable not found"**

- Verify all env vars in deployment platform
- Check variable names match exactly
- Restart deployment

### Runtime Errors

**Error: "Cannot connect to Supabase"**

- Verify Supabase URL in production
- Check API keys are correct
- Ensure RLS policies allow access

**Error: "500 Internal Server Error"**

- Check server logs
- Verify database connection
- Check for missing migrations

---

## 📈 Scaling Considerations

### Database Optimization

```sql
-- Add indexes for better performance
CREATE INDEX idx_animals_category ON animals(category);
CREATE INDEX idx_user_progress_user_id ON user_progress(user_id);
```

### Caching Strategy

- Use SWR or React Query for client caching
- Implement Redis for server-side caching
- CDN for static assets

### Load Balancing

- Use Vercel's automatic load balancing
- Or implement custom with Nginx

---

## 🎯 Launch Checklist

Pre-launch:

- [ ] All features working
- [ ] Mobile responsive
- [ ] Cross-browser tested
- [ ] SEO optimized
- [ ] Analytics configured
- [ ] Error tracking setup
- [ ] Database backed up
- [ ] SSL certificate active
- [ ] Custom domain configured
- [ ] Privacy policy added
- [ ] Terms of service added

Post-launch:

- [ ] Monitor error rates
- [ ] Check performance metrics
- [ ] Gather user feedback
- [ ] Plan next features

---

## 📞 Support

If you encounter issues:

1. Check logs in deployment platform
2. Review Supabase logs
3. Check GitHub issues
4. Contact support

---

**Happy Deploying! 🚀**
