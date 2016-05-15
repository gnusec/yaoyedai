CREATE TABLE `diyou_queue` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`act_type`  tinyint(2) NULL DEFAULT NULL ,
`total_status`  tinyint(2) NULL DEFAULT NULL ,
`single_status`  tinyint(2) NULL DEFAULT NULL ,
`money`  decimal(15,0) NULL DEFAULT NULL ,
`create_at`  int(10) NULL DEFAULT NULL ,
`update_at`  int(10) NULL DEFAULT NULL ,
`borrow_type`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`tender_time`  int(10) NULL DEFAULT NULL ,
`tender_nid`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`borrow_nid`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`user_id`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=6
ROW_FORMAT=COMPACT
;



CREATE TABLE `diyou_queue_log` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`user_id`  int(11) NULL DEFAULT NULL ,
`voucher_type`  tinyint(2) NULL DEFAULT NULL ,
`voucher_money`  decimal(10,2) NULL DEFAULT NULL ,
`one_level_inviter_userid`  int(11) NULL DEFAULT NULL ,
`one_level_voucher_money`  decimal(10,2) NULL DEFAULT NULL ,
`two_level_inviter_userid`  int(11) NULL DEFAULT NULL ,
`two_level_voucher_money`  decimal(11,2) NULL DEFAULT NULL ,
`created_at`  int(11) NULL DEFAULT NULL ,
`updated_at`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=7
ROW_FORMAT=COMPACT
;


ALTER TABLE diyou_vouchers_type  ADD COLUMN single_quota  decimal(10,2);
ALTER TABLE diyou_vouchers_type  ADD COLUMN total_quota  decimal(10,2);
ALTER TABLE diyou_vouchers_type  ADD COLUMN one_inviter_money  decimal(10,2);
ALTER TABLE diyou_vouchers_type  ADD COLUMN two_inviter_money  decimal(10,2);
