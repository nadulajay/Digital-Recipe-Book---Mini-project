

SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `recipe_book` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `recipe_book`;

-- Drop existing tables cleanly without Foreign Key conflicts

DROP TABLE IF EXISTS `recipes`;
DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `users`;

-- Table 1: users
-- Secure user authentication table storing BCRYPT hashed passwords

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample User Password is 'password123' (Hashed with PASSWORD_BCRYPT)
INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'chef_jayasinghe', 'jayasinghe@flavorforge.com', '$2y$10$e8wY8wV3vN/G3h5QdJzK7eW1a9yUqZ8xM1p9yL8vQ7wE6rT5yU4iO'),
(2, 'perera_cook', 'perera@flavorforge.com', '$2y$10$e8wY8wV3vN/G3h5QdJzK7eW1a9yUqZ8xM1p9yL8vQ7wE6rT5yU4iO');


-- Table 2: messages
-- Contact page submissions table using safe prepared statements

CREATE TABLE `messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `messages` (`id`, `name`, `email`, `message`) VALUES
(1, 'Sithumi Perera', 'sithumi@gmail.com', 'Hello FlavorForge team! I love the Sri Lankan chicken curry recipe. Could you add more traditional Sri Lankan dessert recipes?'),
(2, 'Kamal Silva', 'kamal.silva@yahoo.com', 'Great website design! The cooking time filter slider works smoothly.');


-- Table 3: recipes (Theme-Specific Table)
-- Main recipe table storing title, category, prep time, difficulty, ingredients, instructions

CREATE TABLE `recipes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `prep_time` INT(11) NOT NULL,
  `difficulty` VARCHAR(20) NOT NULL,
  `ingredients` TEXT NOT NULL,
  `instructions` TEXT NOT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `user_id` INT(11) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_recipes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `recipes` (`id`, `title`, `category`, `prep_time`, `difficulty`, `ingredients`, `instructions`, `image_url`, `user_id`) VALUES
(1, 'Spicy Sri Lankan Chicken Curry', 'Dinner', 45, 'Medium', 
'1 kg Chicken, cut into pieces\n2 tbsp Roasted Sri Lankan Curry Powder\n1 cup Thick Coconut Milk\n1 large Onion, chopped\n4 cloves Garlic & 1 inch Ginger, minced\nCurry leaves, Rampe (Pandan leaf), and Lemongrass\n1 cinnamon stick & cardamom pods\n2 tbsp Cooking Oil & Salt to taste', 
'Marinate chicken with curry powder, chili powder, turmeric, minced garlic, and ginger for 20 mins.\nHeat oil in a heavy pot, saute onions, curry leaves, rampe, cinnamon, and lemongrass until fragrant.\nAdd marinated chicken and sear until browned on all sides.\nPour in thin coconut milk or water, cover and simmer for 25 minutes until chicken is tender.\nStir in thick coconut milk, cook for another 5 minutes on low heat. Serve hot with rice!', 
'pictures/Chicken curry.png', 1),

(2, 'strawberry pancake', 'Breakfast', 20, 'Easy', 
'1.5 cups All-purpose Flour\n3.5 tsp Baking Powder\n1 tsp Salt & 1 tbsp Sugar\n1.25 cups Milk\n1 Egg & 3 tbsp Melted Butter\n1 cup Fresh Strawberries, sliced\nMaple syrup or honey for drizzling', 
'In a large bowl, sift together flour, baking powder, salt, and sugar.\nMake a well in the center and pour in milk, egg, and melted butter; mix until smooth.\nHeat a lightly oiled griddle or frying pan over medium-high heat.\nPour batter onto the griddle, cook until bubbles form and flip until golden brown.\nServe hot stacked with sliced strawberries and generous maple syrup.', 
'pictures/Strawberry pancake.png', 2),

(3, 'Chocolate Lava Cake', 'Dessert', 25, 'Medium', 
'100g Bittersweet Dark Chocolate\n1/2 cup Unsalted Butter\n2 Eggs + 2 Egg yolks\n1/4 cup Powdered Sugar\n3 tbsp All-purpose Flour\nPinch of Salt & Vanilla Extract', 
'Preheat oven to 220°C (425°F). Grease ramekins and dust with cocoa powder.\nMelt dark chocolate and butter together in a heatproof bowl over simmering water.\nWhisk eggs, egg yolks, sugar, and vanilla until pale and thick.\nFold melted chocolate and flour gently into egg mixture.\nDivide into ramekins and bake for 12 minutes until edges are firm but center is soft. Invert onto plate!', 
'pictures/Chocolate lava cake .png', 1),

(4, 'Nasi Goreng', 'Lunch', 30, 'Easy', 
'3 cups Day-old cooked Jasmine Rice\n200g Prawns or Chicken bits\n2 tbsp Kecap Manis (Sweet Soy Sauce)\n1 tbsp Sambal Oelek or Chili paste\n3 cloves Garlic & 2 Shallots, finely sliced\n2 Eggs (for frying on top)\nCucumber slices & Prawn crackers for serving', 
'Heat oil in a wok over high heat. Stir-fry garlic, shallots, and chili paste for 1 minute.\nAdd prawns/chicken and stir-fry until fully cooked.\nAdd cooked rice, tossing rapidly to separate grains.\nPour in kecap manis and soy sauce, tossing for 3 minutes until evenly caramelized.\nServe topped with a fried sunny-side-up egg and cucumber slices.', 
'pictures/Nasi goreng.png', 2),

(5, 'Vegetable Chop Suey', 'Lunch', 25, 'Easy', 
'1 cup Broccoli florets & Cauliflower\n1 cup Carrots & Baby Corn, sliced\n1 cup Bok Choy & Mushrooms\n2 cloves Garlic, minced\n2 tbsp Soy Sauce & 1 tbsp Oyster Sauce\n1 tbsp Cornstarch dissolved in 1/2 cup water\nSesame oil & white pepper', 
'Blanch broccoli and carrots in boiling water for 1 minute, drain immediately.\nHeat sesame oil in a wok, saute garlic and ginger until fragrant.\nAdd all vegetables and stir-fry on high heat for 3 minutes.\nPour in soy sauce, oyster sauce, and cornstarch slurry. Stir until sauce thickens to a gloss.\nServe warm as a side dish or main stir-fry!', 
'pictures/Vegetable Chop Suey.png', 1),

(6, 'Lemon Garlic Shrimp Pasta', 'Dinner', 30, 'Medium', 
'250g Linguine or Spaghetti pasta\n400g Large Shrimp, peeled and deveined\n4 cloves Garlic, minced\n1/4 cup Butter & 2 tbsp Olive Oil\nJuice and zest of 1 Fresh Lemon\nFresh Parsley, chopped & Red pepper flakes', 
'Cook pasta in salted boiling water until al dente; reserve 1/2 cup pasta water.\nMelt butter with olive oil in skillet. Add garlic and red pepper flakes, saute 1 minute.\nAdd shrimp, season with salt and pepper, cook 2 minutes per side until pink.\nStir in lemon juice, cooked pasta, and reserved pasta water. Toss gently.\nGarnish with lemon zest and fresh chopped parsley before serving.', 
'pictures/Lemon Garlic Shrimp Pasta.png', 2);

SET FOREIGN_KEY_CHECKS = 1;
