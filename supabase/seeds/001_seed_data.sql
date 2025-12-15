-- KidsLearn Database Seeding
-- Version: 1.0.0
-- Description: Seed data for animals and quiz questions

-- Seed Animals - Mammals
INSERT INTO animals (name, category, description, image_url, sound_url, fun_facts) VALUES
('Dog', 'mammals', 'Dogs have four legs and eat meat, vegetables, and fruits. They are easy to play with and have a distinctive bark.', 'img/dog1.png', 'sound/dog.mp3', ARRAY['Dogs can understand up to 250 words', 'They have an amazing sense of smell', 'Dogs dream just like humans']),
('Elephant', 'mammals', 'Elephants have four legs and eat grass, leaves, tree bark, roots, fruit, and twigs. They have a large body, wide ears, and a long trunk.', 'img/elephant.png', 'sound/Elephant.mp3', ARRAY['Elephants can recognize themselves in mirrors', 'They have excellent memory', 'Elephants communicate through vibrations']),
('Cat', 'mammals', 'Cats are small carnivorous mammals with retractable claws. They are known for their agility and hunting skills.', 'img/kucing.png', 'sound/cat.mp3', ARRAY['Cats spend 70% of their lives sleeping', 'They can rotate their ears 180 degrees', 'Cats have over 20 different vocalizations']),
('Cow', 'mammals', 'Cows are large domesticated mammals that produce milk. They are herbivores and live on farms.', 'img/cow.png', 'sound/cow.mp3', ARRAY['Cows have best friends', 'They can see almost 360 degrees', 'Cows can sleep standing up']),
('Horse', 'mammals', 'Horses are strong mammals used for riding and pulling loads. They are very intelligent and social animals.', 'img/horse.png', 'sound/horse.mp3', ARRAY['Horses can sleep standing up', 'They have excellent memory', 'Horses can run shortly after birth'])
ON CONFLICT (name) DO NOTHING;

-- Seed Animals - Birds
INSERT INTO animals (name, category, description, image_url, sound_url, fun_facts) VALUES
('Parrot', 'birds', 'Parrots are colorful birds that can mimic human speech. They are very intelligent and social.', 'img/parrot.png', 'sound/parrot.mp3', ARRAY['Parrots can live up to 80 years', 'They mate for life', 'Parrots can learn hundreds of words']),
('Eagle', 'birds', 'Eagles are large birds of prey with excellent eyesight. They are powerful hunters.', 'img/eagle.png', 'sound/eagle.mp3', ARRAY['Eagles can see 8 times farther than humans', 'They build the largest nests', 'Eagles can fly at 10,000 feet']),
('Penguin', 'birds', 'Penguins are flightless birds that are excellent swimmers. They live in cold climates.', 'img/penguin.png', 'sound/penguin.mp3', ARRAY['Penguins can hold their breath for 20 minutes', 'They toboggan on their bellies', 'Male penguins give pebbles as gifts'])
ON CONFLICT (name) DO NOTHING;

-- Seed Animals - Sea Animals
INSERT INTO animals (name, category, description, image_url, sound_url, fun_facts) VALUES
('Dolphin', 'sea', 'Dolphins are intelligent marine mammals that communicate using clicks and whistles.', 'img/dolphin.png', 'sound/dolphin.mp3', ARRAY['Dolphins have names for each other', 'They sleep with one eye open', 'Dolphins can recognize themselves in mirrors']),
('Whale', 'sea', 'Whales are the largest animals on Earth. They are gentle giants of the ocean.', 'img/whale.png', 'sound/whale.mp3', ARRAY['Blue whales heart weighs 400 pounds', 'They sing songs that can travel thousands of miles', 'Whales can hold their breath for 90 minutes']),
('Shark', 'sea', 'Sharks are apex predators with sharp teeth and excellent hunting abilities.', 'img/shark.png', 'sound/shark.mp3', ARRAY['Sharks have been around for 400 million years', 'They have electroreceptors', 'Some sharks must keep swimming to breathe'])
ON CONFLICT (name) DO NOTHING;

-- Seed Animals - Insects
INSERT INTO animals (name, category, description, image_url, sound_url, fun_facts) VALUES
('Butterfly', 'insects', 'Butterflies are colorful insects that undergo metamorphosis from caterpillars.', 'img/butterfly.png', 'sound/butterfly.mp3', ARRAY['Butterflies taste with their feet', 'They can see ultraviolet light', 'Some butterflies migrate thousands of miles']),
('Bee', 'insects', 'Bees are important pollinators that produce honey. They live in organized colonies.', 'img/bee.png', 'sound/bee.mp3', ARRAY['Bees can recognize human faces', 'They communicate through dance', 'A bee visits 5,000 flowers per day']),
('Ant', 'insects', 'Ants are social insects that work together in colonies. They are incredibly strong for their size.', 'img/ant.png', 'sound/ant.mp3', ARRAY['Ants can lift 50 times their weight', 'They farm fungus for food', 'Ants teach each other'])
ON CONFLICT (name) DO NOTHING;

-- Seed Animals - Reptiles
INSERT INTO animals (name, category, description, image_url, sound_url, fun_facts) VALUES
('Snake', 'reptiles', 'Snakes are legless reptiles that can unhinge their jaws to swallow large prey.', 'img/snake.png', 'sound/snake.mp3', ARRAY['Snakes smell with their tongues', 'They can sense heat through special organs', 'Some snakes can go months without eating']),
('Turtle', 'reptiles', 'Turtles have protective shells and can live for over 100 years.', 'img/turtle.png', 'sound/turtle.mp3', ARRAY['Some turtles can breathe through their bottoms', 'The oldest turtle lived to 188 years', 'Sea turtles return to birth beach to lay eggs']),
('Crocodile', 'reptiles', 'Crocodiles are large predatory reptiles that live in water and on land.', 'img/crocodile.png', 'sound/crocodile.mp3', ARRAY['Crocodiles have the strongest bite', 'They cry tears while eating', 'Crocodiles can live up to 70 years'])
ON CONFLICT (name) DO NOTHING;

-- Seed Animals - Amphibians
INSERT INTO animals (name, category, description, image_url, sound_url, fun_facts) VALUES
('Frog', 'amphibians', 'Frogs are amphibians that can live both in water and on land. They catch insects with their long tongues.', 'img/frog.png', 'sound/frog.mp3', ARRAY['Frogs absorb water through their skin', 'Some frogs can freeze and thaw', 'Frogs swallow with their eyes']),
('Salamander', 'amphibians', 'Salamanders look like lizards but are amphibians. Some can regrow lost limbs.', 'img/salamander.png', 'sound/salamander.mp3', ARRAY['Salamanders can regenerate limbs', 'They breathe through their skin', 'Some are poisonous'])
ON CONFLICT (name) DO NOTHING;

-- Seed Quiz Questions - Mammals
INSERT INTO quiz_questions (question, category, correct_answer, options, image_url, difficulty) VALUES
('What mammal is this?', 'mammals', 'cat', ARRAY['cat', 'dog', 'cow', 'ant'], 'img/kucing.png', 'easy'),
('Which animal has a trunk?', 'mammals', 'elephant', ARRAY['elephant', 'dog', 'cat', 'cow'], 'img/elephant.png', 'easy'),
('What animal barks?', 'mammals', 'dog', ARRAY['dog', 'cat', 'cow', 'elephant'], 'img/dog1.png', 'easy'),
('Which animal produces milk on farms?', 'mammals', 'cow', ARRAY['cow', 'dog', 'cat', 'elephant'], 'img/cow.png', 'medium')
ON CONFLICT DO NOTHING;

-- Seed Quiz Questions - Birds
INSERT INTO quiz_questions (question, category, correct_answer, options, image_url, difficulty) VALUES
('Which bird can talk?', 'birds', 'parrot', ARRAY['parrot', 'eagle', 'penguin', 'owl'], 'img/parrot.png', 'easy'),
('Which bird cannot fly but is a great swimmer?', 'birds', 'penguin', ARRAY['penguin', 'eagle', 'parrot', 'duck'], 'img/penguin.png', 'medium'),
('Which bird has the best eyesight?', 'birds', 'eagle', ARRAY['eagle', 'parrot', 'penguin', 'crow'], 'img/eagle.png', 'medium')
ON CONFLICT DO NOTHING;

-- Seed Quiz Questions - Sea Animals
INSERT INTO quiz_questions (question, category, correct_answer, options, image_url, difficulty) VALUES
('Which sea animal is known for its intelligence?', 'sea', 'dolphin', ARRAY['dolphin', 'whale', 'shark', 'fish'], 'img/dolphin.png', 'easy'),
('What is the largest animal on Earth?', 'sea', 'whale', ARRAY['whale', 'elephant', 'shark', 'dolphin'], 'img/whale.png', 'medium'),
('Which sea creature has been around for 400 million years?', 'sea', 'shark', ARRAY['shark', 'dolphin', 'whale', 'octopus'], 'img/shark.png', 'hard')
ON CONFLICT DO NOTHING;

-- Seed Quiz Questions - Insects
INSERT INTO quiz_questions (question, category, correct_answer, options, image_url, difficulty) VALUES
('Which insect makes honey?', 'insects', 'bee', ARRAY['bee', 'ant', 'butterfly', 'beetle'], 'img/bee.png', 'easy'),
('Which insect can lift 50 times its weight?', 'insects', 'ant', ARRAY['ant', 'bee', 'butterfly', 'cricket'], 'img/ant.png', 'medium'),
('Which insect undergoes metamorphosis?', 'insects', 'butterfly', ARRAY['butterfly', 'ant', 'bee', 'beetle'], 'img/butterfly.png', 'medium')
ON CONFLICT DO NOTHING;
