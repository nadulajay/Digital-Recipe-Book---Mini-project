document.addEventListener('DOMContentLoaded', function () {
    console.log('FlavorForge Application Initialized');

    // Initialize Tooltips & Popovers if available
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

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
});

// Centralized Recipe Database for Dynamic Modal Display
const recipeDatabase = {
    1: {
        title: "Spicy Sri Lankan Chicken Curry",
        category: "Dinner",
        time: "45 mins",
        difficulty: "Medium",
        image: "https://images.unsplash.com/photo-1588166524941-3bf61a9c41db?auto=format&fit=crop&w=800&q=80",
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
        image: "https://images.unsplash.com/photo-1528207776546-365bb710ee93?auto=format&fit=crop&w=800&q=80",
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