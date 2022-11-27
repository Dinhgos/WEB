-- MySQL Script generated by MySQL Workbench
-- Wed Jan  6 15:12:06 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema kivweb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `product` ;

CREATE TABLE IF NOT EXISTS `product` (
  `id_product` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `price` INT NOT NULL,
  `description` TEXT(200) NOT NULL,
  PRIMARY KEY (`id_product`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user` ;

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `right` INT NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;


-- -----------------------------------------------------
-- Table `review`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `review` ;

CREATE TABLE IF NOT EXISTS `review` (
  `id_review` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_product` INT NOT NULL,
  `rating` INT NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  `text` TEXT(200) NOT NULL,
  `hidden` BIT(1) NOT NULL,
  PRIMARY KEY (`id_review`),
  INDEX `fk_uzivatel_id_uzivatel_idx` (`id_user` ASC) ,
  INDEX `fk_produkt_id_produkt_idx` (`id_product` ASC) ,
  CONSTRAINT `fk_produkt_id_produkt`
    FOREIGN KEY (`id_product`)
    REFERENCES `product` (`id_product`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_uzivatel_id_uzivatel`
    FOREIGN KEY (`id_user`)
    REFERENCES `user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_czech_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `product`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `product` (`id_product`, `name`, `price`, `description`) VALUES (1, 'product1', 6, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam dictum tincidunt diam.');
INSERT INTO `product` (`id_product`, `name`, `price`, `description`) VALUES (2, 'product2', 54, 'Nullam faucibus mi quis velit. Aliquam in lorem sit amet leo accumsan lacinia.');
INSERT INTO `product` (`id_product`, `name`, `price`, `description`) VALUES (3, 'product3', 7897, 'Aliquam ornare wisi eu metus. Aenean id metus id velit ullamcorper pulvinar.');
INSERT INTO `product` (`id_product`, `name`, `price`, `description`) VALUES (4, 'product4', 86465, 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.');
INSERT INTO `product` (`id_product`, `name`, `price`, `description`) VALUES (5, 'product5', 87, 'Etiam bibendum elit eget erat. Nunc auctor. Maecenas ipsum velit, consectetuer eu lobortis ut, dictum at dui.');
INSERT INTO `product` (`id_product`, `name`, `price`, `description`) VALUES (6, 'product6', 6548, 'Nam sed tellus id magna elementum tincidunt. Nulla accumsan, elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel leo.');

COMMIT;


-- -----------------------------------------------------
-- Data for table `user`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `user` (`id_user`, `right`, `login`, `password`, `name`, `email`) VALUES (1, 1, 'nuzivatel', 'admin', 'uzivatel_name', 'test@test.com');
INSERT INTO `user` (`id_user`, `right`, `login`, `password`, `name`, `email`) VALUES (2, 2, 'konzument', 'admin', 'konzument_name', 'test@test.com');
INSERT INTO `user` (`id_user`, `right`, `login`, `password`, `name`, `email`) VALUES (3, 3, 'spravce', 'admin', 'spravce_name', 'test@test.com');
INSERT INTO `user` (`id_user`, `right`, `login`, `password`, `name`, `email`) VALUES (4, 4, 'administrator', 'admin', 'administrator_name', 'test@test.com');

COMMIT;


-- -----------------------------------------------------
-- Data for table `review`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `review` (`id_review`, `id_user`, `id_product`, `rating`, `title`, `text`, `hidden`) VALUES (1, 1, 1, 100, 'title1', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam erat volutpat. Praesent vitae arcu tempor neque lacinia pretium.', 1);
INSERT INTO `review` (`id_review`, `id_user`, `id_product`, `rating`, `title`, `text`, `hidden`) VALUES (2, 2, 2, 80, 'title2', 'Aliquam erat volutpat. Maecenas aliquet accumsan leo. Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat.', 1);
INSERT INTO `review` (`id_review`, `id_user`, `id_product`, `rating`, `title`, `text`, `hidden`) VALUES (3, 3, 3, 60, 'title3', 'In sem justo, commodo ut, suscipit at, pharetra vitae, orci. Aliquam ante. Nullam dapibus fermentum ipsum.', 0);
INSERT INTO `review` (`id_review`, `id_user`, `id_product`, `rating`, `title`, `text`, `hidden`) VALUES (4, 1, 4, 40, 'title4', 'Aenean fermentum risus id tortor. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?', 0);
INSERT INTO `review` (`id_review`, `id_user`, `id_product`, `rating`, `title`, `text`, `hidden`) VALUES (5, 2, 5, 20, 'title5', 'Mauris dolor felis, sagittis at, luctus sed, aliquam non, tellus. Nullam justo enim, consectetuer nec, ullamcorper ac, vestibulum in, elit.', 0);

COMMIT;

