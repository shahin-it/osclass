CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_ec_category (
  pk_c_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,

  b_active BOOLEAN DEFAULT TRUE,

  s_name VARCHAR(255) NOT NULL,
  s_image VARCHAR(255) NULL,
  s_description VARCHAR(65535) NULL,

  dt_created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',

  i_parent_id INT UNSIGNED NULL,

  UNIQUE (s_name),
  PRIMARY KEY (pk_c_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';




CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_ec_product (
  pk_p_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,

  b_active BOOLEAN DEFAULT TRUE,
  b_is_onsale BOOLEAN DEFAULT FALSE,
  b_is_new BOOLEAN DEFAULT TRUE,
  b_is_feature BOOLEAN DEFAULT FALSE,
  b_allow_stock BOOLEAN DEFAULT FALSE,

  s_name VARCHAR(255) NOT NULL,
  s_url VARCHAR(255) NULL,
  s_image VARCHAR(255) NULL,
  s_image1 VARCHAR(255) NULL,
  s_image2 VARCHAR(255) NULL,
  s_image3 VARCHAR(255) NULL,
  s_image4 VARCHAR(255) NULL,
  s_brand VARCHAR(100) NULL,
  s_model VARCHAR(100) NULL,
  s_size VARCHAR(100) NULL,
  s_color VARCHAR(100) NULL,

  s_description VARCHAR(65535) NULL,

  i_quantity INT(9) UNSIGNED NOT NULL DEFAULT 1,
  d_base_price DOUBLE(9, 4) DEFAULT 0.0,
  d_sale_price DOUBLE(9, 4) DEFAULT 0.0,

  dt_created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  dt_updated DATETIME DEFAULT '0000-00-00 00:00:00',

  fk_c_id INT UNSIGNED NULL,

  PRIMARY KEY (pk_p_id),
  UNIQUE (s_name, s_url),
  FOREIGN KEY (fk_c_id) REFERENCES /*TABLE_PREFIX*/t_ec_category(pk_c_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';




CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_ec_order (
  pk_o_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,

  s_customer_name VARCHAR(255) NOT NULL ,
  s_customer_email VARCHAR(255) NOT NULL ,

  i_c_id INT(10) UNSIGNED NULL,

  dt_created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',

  d_order_total DOUBLE(9, 4) DEFAULT 0.0,

  s_order_status VARCHAR(10) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (pk_o_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';




CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_ec_order_item (
  pk_item_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,

  s_name VARCHAR(255) NOT NULL,
  d_price DOUBLE(9, 4) DEFAULT 0.0,

  fk_o_id INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (pk_item_id),
  FOREIGN KEY (fk_o_id) REFERENCES /*TABLE_PREFIX*/t_ec_order(pk_o_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';




CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_ec_payment (
  pk_pay_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,

  s_gateway_name VARCHAR(50) NOT NULL ,
  s_payment_ref VARCHAR(50) NOT NULL ,
  s_payment_status VARCHAR(10) DEFAULT 'unpaid',
  s_customer_email VARCHAR(255) NOT NULL,

  d_payment_total DOUBLE(9, 4) DEFAULT 0.0,

  dt_created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  b_order_status VARCHAR(10) DEFAULT 'pending',

  fk_o_id INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (pk_pay_id),
  FOREIGN KEY (fk_o_id) REFERENCES /*TABLE_PREFIX*/t_ec_order(pk_o_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';