

document.addEventListener('DOMContentLoaded', function () {
    console.log('FlavorForge Application Initialized');

    // Initialize Tooltips if available
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Newsletter Subscription Form Handler
    const newsletterBtn = document.getElementById('newsletter-submit');
    if (newsletterBtn) {
        newsletterBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const emailInput = document.getElementById('newsletter-email');
            if (emailInput && emailInput.value.trim() !== '') {
                alert('Thank you for subscribing to FlavorForge newsletter updates!');
                emailInput.value = '';
            } else {
                alert('Please enter a valid email address.');
            }
        });
    }

    // Bootstrap Modal Event Listener for Recipe Modal
    const recipeModalEl = document.getElementById('recipeModal');
    if (recipeModalEl) {
        recipeModalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button && (button.hasAttribute('data-title') || button.hasAttribute('data-recipe-id'))) {
                openRecipeModal(button);
            }
        });
    }
});

// Fallback Static Recipe Database for static pages
const recipeDatabase = {
    1: {
        title: "Spicy Sri Lankan Chicken Curry",
        category: "Dinner",
        time: "45 mins",
        difficulty: "Medium",
        image: "pictures/Chicken curry.png",
        description: "Authentic Sri Lankan chicken curry infused with roasted spices, coconut milk, and curry leaves.",
        ingredients: [
            "1 kg Chicken, cut into pieces",
            "2 tbsp Roasted Sri Lankan Curry Powder",
            "1 cup Thick Coconut Milk",
            "1 large Onion, chopped",
            "4 cloves Garlic & 1 inch Ginger, minced",
            "Curry leaves, Rampe (Pandan leaf), and Lemongrass",
            "1 cinnamon stick & cardamom pods",
            "2 tbsp Cooking Oil & Salt to taste"
        ],
        instructions: [
            "Marinate chicken with curry powder, chili powder, turmeric, minced garlic, and ginger for 20 mins.",
            "Heat oil in a heavy pot, saute onions, curry leaves, rampe, cinnamon, and lemongrass until fragrant.",
            "Add marinated chicken and sear until browned on all sides.",
            "Pour in thin coconut milk or water, cover and simmer for 25 minutes until chicken is tender.",
            "Stir in thick coconut milk, cook for another 5 minutes on low heat. Serve hot with rice!"
        ]
    },
    2: {
        title: "Strawberry Pancake",
        category: "Breakfast",
        time: "20 mins",
        difficulty: "Easy",
        image: "pictures/Strawberry pancake.png",
        description: "Fluffy Japanese-style pancakes topped with fresh strawberries and maple syrup.",
        ingredients: [
            "1.5 cups All-purpose Flour",
            "3.5 tsp Baking Powder",
            "1 tsp Salt & 1 tbsp Sugar",
            "1.25 cups Milk",
            "1 Egg & 3 tbsp Melted Butter",
            "1 cup Fresh Strawberries, sliced",
            "Maple syrup or honey for drizzling"
        ],
        instructions: [
            "In a large bowl, sift together flour, baking powder, salt, and sugar.",
            "Make a well in the center and pour in milk, egg, and melted butter; mix until smooth.",
            "Heat a lightly oiled griddle or frying pan over medium-high heat.",
            "Pour batter onto the griddle, cook until bubbles form and flip until golden brown.",
            "Serve hot stacked with sliced strawberries and generous maple syrup."
        ]
    },
    3: {
        title: "Chocolate Lava Cake",
        category: "Dessert",
        time: "25 mins",
        difficulty: "Medium",
        image: "pictures/Chocolate lava cake .png",
        description: "Warm individual chocolate cakes with a luscious molten chocolate center.",
        ingredients: [
            "100g Bittersweet Dark Chocolate",
            "1/2 cup Unsalted Butter",
            "2 Eggs + 2 Egg yolks",
            "1/4 cup Powdered Sugar",
            "3 tbsp All-purpose Flour",
            "Pinch of Salt & Vanilla Extract"
        ],
        instructions: [
            "Preheat oven to 220°C (425°F). Grease ramekins and dust with cocoa powder.",
            "Melt dark chocolate and butter together in a heatproof bowl over simmering water.",
            "Whisk eggs, egg yolks, sugar, and vanilla until pale and thick.",
            "Fold melted chocolate and flour gently into egg mixture.",
            "Divide into ramekins and bake for 12 minutes until edges are firm but center is soft. Invert onto plate!"
        ]
    },
    4: {
        title: "Nasi Goreng",
        category: "Lunch",
        time: "30 mins",
        difficulty: "Easy",
        image: "pictures/Nasi goreng.png",
        description: "Classic Indonesian fried rice cooked with sweet soy sauce, chili paste, and fried egg.",
        ingredients: [
            "3 cups Day-old cooked Jasmine Rice",
            "200g Prawns or Chicken bits",
            "2 tbsp Kecap Manis (Sweet Soy Sauce)",
            "1 tbsp Sambal Oelek or Chili paste",
            "3 cloves Garlic & 2 Shallots, finely sliced",
            "2 Eggs (for frying on top)",
            "Cucumber slices & Prawn crackers for serving"
        ],
        instructions: [
            "Heat oil in a wok over high heat. Stir-fry garlic, shallots, and chili paste for 1 minute.",
            "Add prawns/chicken and stir-fry until fully cooked.",
            "Add cooked rice, tossing rapidly to separate grains.",
            "Pour in kecap manis and soy sauce, tossing for 3 minutes until evenly caramelized.",
            "Serve topped with a fried sunny-side-up egg and cucumber slices."
        ]
    },
    5: {
        title: "Vegetable Chop Suey",
        category: "Lunch",
        time: "25 mins",
        difficulty: "Easy",
        image: "pictures/Vegetable Chop Suey.png",
        description: "Crispy colorful vegetables stir-fried in a rich savory garlic sauce.",
        ingredients: [
            "1 cup Broccoli florets & Cauliflower",
            "1 cup Carrots & Baby Corn, sliced",
            "1 cup Bok Choy & Mushrooms",
            "2 cloves Garlic, minced",
            "2 tbsp Soy Sauce & 1 tbsp Oyster Sauce",
            "1 tbsp Cornstarch dissolved in 1/2 cup water",
            "Sesame oil & white pepper"
        ],
        instructions: [
            "Blanch broccoli and carrots in boiling water for 1 minute, drain immediately.",
            "Heat sesame oil in a wok, saute garlic and ginger until fragrant.",
            "Add all vegetables and stir-fry on high heat for 3 minutes.",
            "Pour in soy sauce, oyster sauce, and cornstarch slurry. Stir until sauce thickens to a gloss.",
            "Serve warm as a side dish or main stir-fry!"
        ]
    },
    6: {
        title: "Lemon Garlic Shrimp Pasta",
        category: "Dinner",
        time: "30 mins",
        difficulty: "Medium",
        image: "pictures/Lemon Garlic Shrimp Pasta.png",
        description: "Succulent shrimp tossed in linguine with fresh lemon juice, garlic butter, and parsley.",
        ingredients: [
            "250g Linguine or Spaghetti pasta",
            "400g Large Shrimp, peeled and deveined",
            "4 cloves Garlic, minced",
            "1/4 cup Butter & 2 tbsp Olive Oil",
            "Juice and zest of 1 Fresh Lemon",
            "Fresh Parsley, chopped & Red pepper flakes",
            "Cook pasta in salted boiling water until al dente; reserve 1/2 cup pasta water.",
            "Melt butter with olive oil in skillet. Add garlic and red pepper flakes, saute 1 minute.",
            "Add shrimp, season with salt and pepper, cook 2 minutes per side until pink.",
            "Stir in lemon juice, cooked pasta, and reserved pasta water. Toss gently.",
            "Garnish with lemon zest and fresh chopped parsley before serving."
        ]
    }
};

/*
  Universal Function to Open & Populate Recipe Detail Modal
 */
function openRecipeModal(recipeIdOrElement) {
    let recipe = null;

    if (typeof recipeIdOrElement === 'number' || typeof recipeIdOrElement === 'string') {
        const id = parseInt(recipeIdOrElement);
        if (window.dbRecipes && window.dbRecipes[id]) {
            recipe = window.dbRecipes[id];
        } else if (recipeDatabase[id]) {
            recipe = recipeDatabase[id];
        }
    } else if (typeof recipeIdOrElement === 'object' && recipeIdOrElement !== null) {
        const btn = recipeIdOrElement;
        const idAttr = btn.getAttribute('data-recipe-id');
        
        if (idAttr && window.dbRecipes && window.dbRecipes[parseInt(idAttr)]) {
            recipe = window.dbRecipes[parseInt(idAttr)];
        } else {
            const ingredientsRaw = btn.getAttribute('data-ingredients') || '';
            const instructionsRaw = btn.getAttribute('data-instructions') || '';

            const ingredientsArr = ingredientsRaw.split('\n').map(i => i.trim()).filter(i => i.length > 0);
            const instructionsArr = instructionsRaw.split('\n').map(i => i.trim()).filter(i => i.length > 0);

            recipe = {
                title: btn.getAttribute('data-title') || 'Recipe Details',
                category: btn.getAttribute('data-category') || 'General',
                time: btn.getAttribute('data-time') || 'N/A',
                difficulty: btn.getAttribute('data-difficulty') || 'Medium',
                image: btn.getAttribute('data-image') || 'pictures/photo-1498837167922-ddd27525d352.avif',
                ingredients: ingredientsArr.length > 0 ? ingredientsArr : ['Ingredients provided in recipe.'],
                instructions: instructionsArr.length > 0 ? instructionsArr : ['Instructions provided in recipe.']
            };
        }
    }

    if (!recipe) {
        console.error('Recipe not found for:', recipeIdOrElement);
        return;
    }

    // Populate Modal UI Elements
    const modalTitle = document.getElementById('recipeModalLabel');
    const modalImage = document.getElementById('modalRecipeImage');
    const modalCategory = document.getElementById('modalRecipeCategory');
    const modalTime = document.getElementById('modalRecipeTime');
    const modalDifficulty = document.getElementById('modalRecipeDifficulty');
    const modalIngredients = document.getElementById('modalRecipeIngredients');
    const modalInstructions = document.getElementById('modalRecipeInstructions');

    if (modalTitle) modalTitle.innerText = recipe.title;
    if (modalImage) modalImage.src = recipe.image;
    if (modalCategory) modalCategory.innerText = recipe.category;
    if (modalTime) modalTime.innerText = recipe.time;
    if (modalDifficulty) modalDifficulty.innerText = recipe.difficulty;

    // Populate Ingredients List
    if (modalIngredients) {
        modalIngredients.innerHTML = '';
        recipe.ingredients.forEach(item => {
            const li = document.createElement('li');
            li.className = 'ingredient-item';
            li.innerHTML = `<i class="bi bi-check2-circle text-danger me-2"></i>${item}`;
            modalIngredients.appendChild(li);
        });
    }

    // Populate Cooking Instructions List
    if (modalInstructions) {
        modalInstructions.innerHTML = '';
        recipe.instructions.forEach((step, index) => {
            const stepDiv = document.createElement('div');
            stepDiv.className = 'instruction-step';
            stepDiv.innerHTML = `<span class="step-number">${index + 1}</span> ${step}`;
            modalInstructions.appendChild(stepDiv);
        });
    }

    // Open Modal via Bootstrap API or Fallback
    const modalElement = document.getElementById('recipeModal');
    if (modalElement) {
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const bsModal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            bsModal.show();
        } else {
            modalElement.classList.add('show');
            modalElement.style.display = 'block';
            document.body.classList.add('modal-open');
        }
    }
}

// Explicitly attach openRecipeModal to window globally
window.openRecipeModal = openRecipeModal;
