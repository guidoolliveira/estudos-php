-- MySQL Script generated by MySQL Workbench
-- Mon May 27 00:59:20 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema crud
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema crud
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `crud` DEFAULT CHARACTER SET utf8 ;
USE `crud` ;

-- -----------------------------------------------------
-- Table `login`
-- -----------------------------------------------------
CREATE TABLE `login` (
  `id` INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `nivelAcesso` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `especializacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `especializacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nomeEspecializacao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `instrutores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `instrutores` (
  `idinstrutores` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `celular` VARCHAR(45) NOT NULL,
  `idespecializacao` INT NOT NULL,
  PRIMARY KEY (`idinstrutores`),
    FOREIGN KEY (`idespecializacao`)
    REFERENCES `especializacao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `produto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `quantidade` INT NOT NULL DEFAULT 0,
  `preço` FLOAT NOT NULL,
  `idcategoria` INT NOT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`idcategoria`)
    REFERENCES `categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cursos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(45) NOT NULL,
  `horaInicio` VARCHAR(45) NOT NULL,
  `horaFinal` VARCHAR(45) NOT NULL,
  `dias` TIME(0) NOT NULL,
  `idinstrutores` INT NOT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`idinstrutores`)
    REFERENCES `instrutores` (`idinstrutores`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
INSERT INTO login (nome, email, usuario, senha, nivelAcesso) VALUES ("administrador" , "admin@gmail.com" , "admin" ,"12345678" ,"1");
INSERT INTO login (nome, email, usuario, senha, nivelAcesso) VALUES ("funcionario" , "funcionario@gmail.com" , "funcionario" ,"12345678" ,"0");


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
