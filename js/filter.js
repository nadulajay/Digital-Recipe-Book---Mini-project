document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchQuery');
    const categoryCheckboxes = document.querySelectorAll('.category-check');
    const difficultyCheckboxes = document.querySelectorAll('.difficulty-check');
    const timeSlider = document.getElementById('timeRangeSlider');
    const timeValueLabel = document.getElementById('timeValueLabel');
    const quickTimeBtns = document.querySelectorAll('.quick-filter-btn');
    const tagPills = document.querySelectorAll('.tag-pill');
    const resetFiltersBtn = document.getElementById('resetFilters');
    const recipeCards = document.querySelectorAll('.recipe-grid-item');
    const resultCountHeading = document.getElementById('resultCountHeading');

    // Return if not on dashboard page
    if (!recipeCards.length) return;

    // Filter Trigger Event Handler
    function filterRecipes() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const maxTime = timeSlider ? parseInt(timeSlider.value) : 120;
        
        // Selected Categories
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value.toLowerCase());

        // Selected Difficulties
        const selectedDifficulties = Array.from(difficultyCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value.toLowerCase());

        let visibleCount = 0;

        recipeCards.forEach(card => {
            const title = card.getAttribute('data-title') ? card.getAttribute('data-title').toLowerCase() : '';
            const category = card.getAttribute('data-category') ? card.getAttribute('data-category').toLowerCase() : '';
            const difficulty = card.getAttribute('data-difficulty') ? card.getAttribute('data-difficulty').toLowerCase() : '';
            const time = card.getAttribute('data-time') ? parseInt(card.getAttribute('data-time')) : 0;
            const tags = card.getAttribute('data-tags') ? card.getAttribute('data-tags').toLowerCase() : '';

            // Match conditions
            const matchesQuery = query === '' || title.includes(query) || tags.includes(query) || category.includes(query);
            const matchesCategory = selectedCategories.length === 0 || selectedCategories.includes(category);
            const matchesDifficulty = selectedDifficulties.length === 0 || selectedDifficulties.includes(difficulty);
            const matchesTime = time <= maxTime || maxTime >= 120;

            if (matchesQuery && matchesCategory && matchesDifficulty && matchesTime) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update result heading count
        if (resultCountHeading) {
            resultCountHeading.innerText = `Showing: All Recipes (${visibleCount} results)`;
        }
    }

    // Attach Search Input Event Listener
    if (searchInput) {
        searchInput.addEventListener('input', filterRecipes);
    }

    // Attach Category & Difficulty Checkbox Event Listeners
    categoryCheckboxes.forEach(cb => cb.addEventListener('change', filterRecipes));
    difficultyCheckboxes.forEach(cb => cb.addEventListener('change', filterRecipes));

    // Attach Time Slider Event Listener
    if (timeSlider) {
        timeSlider.addEventListener('input', function () {
            const val = timeSlider.value;
            if (timeValueLabel) {
                timeValueLabel.innerText = val >= 120 ? '120+ min' : `< ${val} min`;
            }
            filterRecipes();
        });
    }

    // Quick Time Filter Buttons (<15m, <30m, etc.)
    quickTimeBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            quickTimeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const targetTime = parseInt(this.getAttribute('data-time-limit'));
            if (timeSlider) {
                timeSlider.value = targetTime;
                if (timeValueLabel) timeValueLabel.innerText = `< ${targetTime} min`;
            }
            filterRecipes();
        });
    });

    // Tag Pills Click Event
    tagPills.forEach(tag => {
        tag.addEventListener('click', function () {
            const tagName = this.innerText.replace('#', '').trim();
            if (searchInput) {
                searchInput.value = tagName;
                filterRecipes();
            }
        });
    });

    // Reset Filters Button Handler
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            categoryCheckboxes.forEach(cb => cb.checked = false);
            difficultyCheckboxes.forEach(cb => cb.checked = false);
            quickTimeBtns.forEach(b => b.classList.remove('active'));
            if (timeSlider) {
                timeSlider.value = 120;
                if (timeValueLabel) timeValueLabel.innerText = '< 45 min';
            }
            filterRecipes();
        });
    }
});