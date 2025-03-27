<?php
    $pageTitle = 'Kezdőlap | iKarRental';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/navbar.php';
?>
    <main>
        <div class="main-wrapper">
            <div class="filter-container">
                <div class="filter-icon">
                    <button class="filter-icon-button"><i class="fa fa-filter"></i></button>
                </div>
                <form class="filter-form hidden" novalidate>
                    <div class="filter-item">
                        <label for="brand">Gyártó:</label>
                        <select name="brand" id="brand">
                            <option value="">Összes</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="year">Évjárat:</label>
                        <select name="year" id="year">
                            <option value="">Összes</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="passengers">Férőhely:</label>
                        <select name="passengers" id="passengers">
                            <option value="">Összes</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="fuel_type">Üzemanyag:</label>
                        <select name="fuel_type" id="fuel_type">
                            <option value="">Összes</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="transmission">Váltó</label>
                        <select name="transmission" id="transmission">
                            <option value="">Összes</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label class="price-label">Ár(Ft):</label>
                        <div class="price-chip">
                            <button type="button" class="price-toggle-button">&#11167;</button>
                            <div class="price-dropdown" style="display: none;">
                                <div class="price-inputs">
                                    <label for="price_from">Min:</label>
                                    <input type="number" name="price-from" id="price_from" placeholder="-tól (1 = 1000Ft)" class="price-input" min="0" step="10">
                                </div>
                                <div class="price-inputs">
                                    <label for="price_to">Max:</label>
                                    <input type="number" name="price-to" id="price_to" placeholder="-ig (1 = 1000Ft)"class="price-input" max="1000" step="10">
                                </div>
                                <button type="button" class="apply-price">Alkalmaz</button>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="filter-button">Keresés</button>
                    </div>
                </form>
            </div>
            <div class="main-content">
                <div class="main-content-grid-wrapper">
                    <?php include 'assets/includes/generate_cars.php'; ?>
                </div>
            </div>
        </div>
    </main>
    
</body>
</html>

<script defer src="/assets/js/filter_cars.js"></script>
<script defer src="/assets/js/filter_price.js"></script>
<script defer src="/assets/js/filter_icon.js"></script>