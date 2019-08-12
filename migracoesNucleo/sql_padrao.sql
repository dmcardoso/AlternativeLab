/*
 Navicat Premium Data Transfer

 Source Server         : root
 Source Server Type    : MySQL
 Source Server Version : 50721
 Source Host           : localhost:3306
 Source Schema         : cidade_ocidental_2018

 Target Server Type    : MySQL
 Target Server Version : 50721
 File Encoding         : 65001

 Date: 25/06/2018 10:59:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pai` int(11) NULL DEFAULT NULL,
  `nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cat_pai`(`pai`) USING BTREE,
  CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`pai`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES (1, NULL, 'Notícia');
INSERT INTO `categorias` VALUES (2, NULL, 'Saúde');
INSERT INTO `categorias` VALUES (3, NULL, 'Educação');

-- ----------------------------
-- Table structure for configs
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs`  (
  `indice` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `valor` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`indice`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of configs
-- ----------------------------
INSERT INTO `configs` VALUES ('aniversario', '');
INSERT INTO `configs` VALUES ('area', '');
INSERT INTO `configs` VALUES ('banners', '539');
INSERT INTO `configs` VALUES ('description', 'Página Oficial da Prefeitura Municipal da Cidade Valparaíso de Goiás - GO');
INSERT INTO `configs` VALUES ('email', '');
INSERT INTO `configs` VALUES ('endereco', '');
INSERT INTO `configs` VALUES ('facebook', 'https://pt-br.facebook.com/valparaisodegoias');
INSERT INTO `configs` VALUES ('fundacao', '');
INSERT INTO `configs` VALUES ('gentilico', '');
INSERT INTO `configs` VALUES ('gplus', '');
INSERT INTO `configs` VALUES ('horario', '');
INSERT INTO `configs` VALUES ('instagram', '');
INSERT INTO `configs` VALUES ('keywords', 'prefeitura, municipal, cidade, estado');
INSERT INTO `configs` VALUES ('linkcidadao', '');
INSERT INTO `configs` VALUES ('local', '');
INSERT INTO `configs` VALUES ('nome_instituicao', 'Valparaíso de Goiás ');
INSERT INTO `configs` VALUES ('populacao', '');
INSERT INTO `configs` VALUES ('scripts', '');
INSERT INTO `configs` VALUES ('telefone', '');
INSERT INTO `configs` VALUES ('tipo_instituicao', '<b>Prefeitura<b/> Municipal de');
INSERT INTO `configs` VALUES ('twitter', '');
INSERT INTO `configs` VALUES ('webmail', '');
INSERT INTO `configs` VALUES ('youtube', '');

-- ----------------------------
-- Table structure for dir_ordem
-- ----------------------------
DROP TABLE IF EXISTS `dir_ordem`;
CREATE TABLE `dir_ordem`  (
  `dir` int(11) NOT NULL,
  `plugin` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`dir`, `plugin`, `id`) USING BTREE,
  INDEX `key_plugin`(`plugin`) USING BTREE,
  CONSTRAINT `dir_ordem_ibfk_1` FOREIGN KEY (`plugin`) REFERENCES `plugins` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `dir_ordem_ibfk_2` FOREIGN KEY (`dir`) REFERENCES `diretorios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dir_ordem
-- ----------------------------
INSERT INTO `dir_ordem` VALUES (10279, 'pagina', 237, 2);
INSERT INTO `dir_ordem` VALUES (10279, 'pagina', 238, 1);

-- ----------------------------
-- Table structure for dir_plugin
-- ----------------------------
DROP TABLE IF EXISTS `dir_plugin`;
CREATE TABLE `dir_plugin`  (
  `dir` int(11) NOT NULL,
  `plugin` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`dir`, `plugin`) USING BTREE,
  INDEX `dir_adm`(`plugin`) USING BTREE,
  CONSTRAINT `dir_plugin_ibfk_1` FOREIGN KEY (`dir`) REFERENCES `diretorios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dir_plugin_ibfk_2` FOREIGN KEY (`plugin`) REFERENCES `plugins` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dir_plugin
-- ----------------------------
INSERT INTO `dir_plugin` VALUES (10281, 'links');
INSERT INTO `dir_plugin` VALUES (10275, 'noticias');
INSERT INTO `dir_plugin` VALUES (10276, 'pagina');
INSERT INTO `dir_plugin` VALUES (10279, 'pagina');
INSERT INTO `dir_plugin` VALUES (10280, 'pagina');
INSERT INTO `dir_plugin` VALUES (10281, 'pagina');

-- ----------------------------
-- Table structure for diretorios
-- ----------------------------
DROP TABLE IF EXISTS `diretorios`;
CREATE TABLE `diretorios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pai` int(11) NULL DEFAULT NULL,
  `nome` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `permissao` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `max_dir` int(11) NULL DEFAULT NULL,
  `ocultar_botoes` int(1) NULL DEFAULT 0,
  `ordem_col` int(1) NULL DEFAULT NULL COMMENT '0 = id, 1 = titulo, 2 = data',
  `ordem_pos` int(1) NULL DEFAULT NULL,
  `redirecionamento` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pai_dir`(`pai`) USING BTREE,
  CONSTRAINT `diretorios_ibfk_1` FOREIGN KEY (`pai`) REFERENCES `diretorios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 10283 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of diretorios
-- ----------------------------
INSERT INTO `diretorios` VALUES (1000, NULL, 'Conteúdo', '2', 30, 0, 2, 1, NULL);
INSERT INTO `diretorios` VALUES (10198, 1000, 'Galerias', '1', 1, 1, 1, 1, 'galerias/$id');
INSERT INTO `diretorios` VALUES (10275, 1000, 'Notícias', '0', 29, 0, 3, 2, NULL);
INSERT INTO `diretorios` VALUES (10276, 1000, 'A Cidade', '0', 29, 0, NULL, NULL, NULL);
INSERT INTO `diretorios` VALUES (10279, 1000, 'Institucional', '0', 29, 1, 4, 1, NULL);
INSERT INTO `diretorios` VALUES (10280, 1000, 'Secretarias', '0', 29, 1, 4, 1, NULL);
INSERT INTO `diretorios` VALUES (10281, 1000, 'Serviços', '0', 29, 1, 4, 1, NULL);
INSERT INTO `diretorios` VALUES (10282, 1000, 'Vereadores', '2', 0, 1, 4, NULL, NULL);

-- ----------------------------
-- Table structure for galerias
-- ----------------------------
DROP TABLE IF EXISTS `galerias`;
CREATE TABLE `galerias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `formatos` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `protecao` int(1) NOT NULL DEFAULT 0,
  `max_img` int(11) NOT NULL DEFAULT 0,
  `capa` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `midias_galeria`(`capa`) USING BTREE,
  CONSTRAINT `galerias_ibfk_1` FOREIGN KEY (`capa`) REFERENCES `midias_uso` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB AUTO_INCREMENT = 541 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of galerias
-- ----------------------------
INSERT INTO `galerias` VALUES (4, 'Banners', 'img', 1, 0, NULL);
INSERT INTO `galerias` VALUES (539, 'Banners', 'img', 1, 0, NULL);

-- ----------------------------
-- Table structure for links
-- ----------------------------
DROP TABLE IF EXISTS `links`;
CREATE TABLE `links`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dir` int(11) NULL DEFAULT NULL,
  `titulo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `link` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `capa` int(11) NULL DEFAULT NULL,
  `oculto` int(1) NULL DEFAULT 0,
  `target` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `links_dir`(`dir`) USING BTREE,
  INDEX `links_capa`(`capa`) USING BTREE,
  CONSTRAINT `links_ibfk_1` FOREIGN KEY (`capa`) REFERENCES `midias_uso` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `links_ibfk_2` FOREIGN KEY (`dir`) REFERENCES `diretorios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for logs_atualizacoes
-- ----------------------------
DROP TABLE IF EXISTS `logs_atualizacoes`;
CREATE TABLE `logs_atualizacoes`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dados_acesso` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `data` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `log_user`(`user_id`) USING BTREE,
  CONSTRAINT `logs_atualizacoes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2239 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for midias
-- ----------------------------
DROP TABLE IF EXISTS `midias`;
CREATE TABLE `midias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `midia` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `titulo` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `imagem` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `data` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `midias_user`(`user_id`) USING BTREE,
  CONSTRAINT `midias_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for midias_uso
-- ----------------------------
DROP TABLE IF EXISTS `midias_uso`;
CREATE TABLE `midias_uso`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `galeria_id` int(11) NULL DEFAULT NULL,
  `midia_id` int(11) NOT NULL,
  `descricao` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `pos_x` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pos_y` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pos_w` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pos_h` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `galeria_id`(`galeria_id`) USING BTREE,
  INDEX `midias_id`(`midia_id`) USING BTREE,
  CONSTRAINT `midias_uso_ibfk_1` FOREIGN KEY (`galeria_id`) REFERENCES `galerias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `midias_uso_ibfk_2` FOREIGN KEY (`midia_id`) REFERENCES `midias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for noticias
-- ----------------------------
DROP TABLE IF EXISTS `noticias`;
CREATE TABLE `noticias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dir` int(11) NULL DEFAULT NULL,
  `categoria` int(11) NULL DEFAULT NULL,
  `titulo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `capa` int(11) NULL DEFAULT NULL,
  `galeria` int(11) NULL DEFAULT NULL,
  `data` datetime(0) NULL DEFAULT NULL,
  `oculto` int(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pg_dir`(`dir`) USING BTREE,
  INDEX `pg_capa`(`capa`) USING BTREE,
  INDEX `pg_galeria`(`galeria`) USING BTREE,
  INDEX `noticias_cat`(`categoria`) USING BTREE,
  CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`capa`) REFERENCES `midias_uso` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `noticias_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `noticias_ibfk_3` FOREIGN KEY (`dir`) REFERENCES `diretorios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `noticias_ibfk_4` FOREIGN KEY (`galeria`) REFERENCES `galerias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for paginas
-- ----------------------------
DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dir` int(11) NULL DEFAULT NULL,
  `titulo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `texto` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `capa` int(11) NULL DEFAULT NULL,
  `galeria` int(11) NULL DEFAULT NULL,
  `oculto` int(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pg_dir`(`dir`) USING BTREE,
  INDEX `pg_capa`(`capa`) USING BTREE,
  INDEX `pg_galeria`(`galeria`) USING BTREE,
  CONSTRAINT `paginas_ibfk_1` FOREIGN KEY (`capa`) REFERENCES `midias_uso` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `paginas_ibfk_2` FOREIGN KEY (`dir`) REFERENCES `diretorios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `paginas_ibfk_3` FOREIGN KEY (`galeria`) REFERENCES `galerias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 244 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for plugins
-- ----------------------------
DROP TABLE IF EXISTS `plugins`;
CREATE TABLE `plugins`  (
  `codigo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dir_tb` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dir_link` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  INDEX `codigo`(`codigo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of plugins
-- ----------------------------
INSERT INTO `plugins` VALUES ('dir', 'Diretórios', NULL, NULL);
INSERT INTO `plugins` VALUES ('configuracoes', 'Configurações', NULL, NULL);
INSERT INTO `plugins` VALUES ('pagina', 'Paginas', 'paginas', 'paginas');
INSERT INTO `plugins` VALUES ('noticias', 'Notícias', 'noticias', 'noticias');
INSERT INTO `plugins` VALUES ('links', 'Links', 'links', 'links');
INSERT INTO `plugins` VALUES ('vereadores', 'Vereadores', 'vereadores', 'vereadores');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `senha` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nome` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fone` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `admin` int(1) NOT NULL DEFAULT 0,
  `desativado` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_nome`(`login`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1001 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1000, 'desenvolvedor', '175829b11831c9d4d13577003e4bf70f', 'Equipe Nucleo', 'suporte@nucleodesenvolvimento.com.br', '(62) 3323-1550', 1, 0);

-- ----------------------------
-- Triggers structure for table links
-- ----------------------------
DROP TRIGGER IF EXISTS `deletar_midias_pgs_copy`;
delimiter ;;
CREATE TRIGGER `deletar_midias_pgs_copy` AFTER DELETE ON `links` FOR EACH ROW BEGIN
DELETE FROM midias_uso WHERE midias_uso.id = OLD.capa;
DELETE FROM dir_ordem WHERE dir_ordem.dir = OLD.dir && dir_ordem.plugin = "links" && dir_ordem.id = OLD.id;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table noticias
-- ----------------------------
DROP TRIGGER IF EXISTS `deletar_midias_noticias`;
delimiter ;;
CREATE TRIGGER `deletar_midias_noticias` AFTER DELETE ON `noticias` FOR EACH ROW BEGIN
DELETE FROM galerias WHERE galerias.id = OLD.galeria;
DELETE FROM midias_uso WHERE midias_uso.id = OLD.capa;
DELETE FROM dir_ordem WHERE dir_ordem.dir = OLD.dir && dir_ordem.plugin = "noticias" && dir_ordem.id = OLD.id;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table paginas
-- ----------------------------
DROP TRIGGER IF EXISTS `deletar_midias_pgs`;
delimiter ;;
CREATE TRIGGER `deletar_midias_pgs` AFTER DELETE ON `paginas` FOR EACH ROW BEGIN
DELETE FROM galerias WHERE galerias.id = OLD.galeria;
DELETE FROM midias_uso WHERE midias_uso.id = OLD.capa;
DELETE FROM dir_ordem WHERE dir_ordem.dir = OLD.dir && dir_ordem.plugin = "institucional" && dir_ordem.id = OLD.id;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
