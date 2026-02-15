<?php

return [
    'single' => 'Product',
    'plural' => 'Products',
    'navigation_label' => 'Products',
    'fields' => [
        'name' => 'Name',
        'unit' => 'Unit',
        'description' => 'Description',
        'preparation_time' => 'Preparation Time (Minutes)',
        'is_active' => 'Active',
        'ingredients_cost' => 'Ingredients Cost',
        'quantity_required' => 'Quantity Required',
    ],
    'sections' => [
        'general' => 'General Information',
        'settings' => 'Settings & Cost',
        'ingredients' => 'Ingredients',
    ],
    'units' => [
        'portion' => 'Portion',
        'tray' => 'Tray',
        'box' => 'Box',
        'package' => 'Package',
        'meal_pack' => 'Meal Pack',
    ],
    'actions' => [
        'add_ingredient' => 'Add Ingredient',
    ],
    'messages' => [
        'active_transactions_warning' => 'This product has active transactions.',
    ],
];
