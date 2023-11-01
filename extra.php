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
