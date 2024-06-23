ALTER TABLE `quotes` ADD `discount` DOUBLE NULL DEFAULT NULL AFTER `currency_type`;

https://mailtrap.io/inboxes


php artisan make:migration add_tendor_no_due_date_to_quotes_table


ALTER TABLE `quotes`
    ADD `i_gst` INT(10) NULL DEFAULT NULL AFTER `discount`,
    ADD `c_gst` INT(10) NULL DEFAULT NULL AFTER `i_gst`,
    ADD `s_gst` INT(10) NULL DEFAULT NULL AFTER `c_gst`,
    ADD `freight` FLOAT NULL DEFAULT NULL AFTER `s_gst`;


To Run Project:
    php artisan serve

    npm run dev


ALTER TABLE `purchase_orders` ADD `terms_n_condition` TEXT NULL DEFAULT NULL AFTER `attn_no`;

ALTER TABLE `products` CHANGE `sale_price` `sale_price` FLOAT NULL DEFAULT NULL;

ALTER TABLE `products`
    ADD `power` VARCHAR(250) NULL DEFAULT NULL AFTER `sale_price`,
    ADD `housing` VARCHAR(250) NULL DEFAULT NULL AFTER `power`,
    ADD `calibration` VARCHAR(250) NULL DEFAULT NULL AFTER `housing`,
    ADD `display` VARCHAR(250) NULL DEFAULT NULL AFTER `calibration`,
    ADD `weighing_units` TEXT NULL DEFAULT NULL AFTER `display`,
    ADD `mpn` VARCHAR(250) NULL DEFAULT NULL AFTER `weighing_units`,
    ADD `capacity` VARCHAR(250) NULL DEFAULT NULL AFTER `mpn`,
    ADD `readability` VARCHAR(250) NULL DEFAULT NULL AFTER `capacity`,
    ADD `pan_size` VARCHAR(250) NULL DEFAULT NULL AFTER `readability`,
    ADD `overall_dimensions` VARCHAR(250) NULL DEFAULT NULL AFTER `pan_size`,
    ADD `shipping_dimensions` VARCHAR(250) NULL DEFAULT NULL AFTER `overall_dimensions`,
    ADD `weight` VARCHAR(250) NULL DEFAULT NULL AFTER `shipping_dimensions`,
    ADD `shipping_weight` VARCHAR(250) NULL DEFAULT NULL AFTER `weight`,
    ADD `item_accessories` TEXT NULL DEFAULT NULL AFTER `shipping_weight`;



$sql = vsprintf(str_replace(array('?'), array('\'%s\''), $source->toSql()), $source->getBindings());
return response()->json($sql);
exit;


--------------------


Products
- power
- housing
- calibration
- display
- Weighing units
- Accessories

Child Product
- MPN
- Capacity
- redability
- Pan size
- Overall Dimensions
- Shipping Dimensions
- Weight
- Shipping Weight
