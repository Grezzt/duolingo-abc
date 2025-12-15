/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: "https",
        hostname: "**.supabase.co",
      },
    ],
  },
  // Enable public folder for static assets
  async rewrites() {
    return [
      {
        source: "/img/:path*",
        destination: "/img/:path*",
      },
      {
        source: "/sound/:path*",
        destination: "/sound/:path*",
      },
    ];
  },
};

module.exports = nextConfig;
