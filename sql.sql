-- 学生表
CREATE TABLE ts_student
(
id INT PRIMARY KEY NOT NULL,
stuname CHAR(10)  NOT NULL,-- 姓名 1
sex CHAR(2) NOT NULL DEFAULT '男' CHECK(sex IN ('男','女')),-- 性别
birthday CHAR(30) NOT NULL ,-- 出生年月
address CHAR(128) NOT NULL, -- 家庭住址
phone CHAR(11) NOT NULL,-- 联系方式
idcard CHAR(20) NOT NULL,-- 身份证号
job TINYINT(1) NOT NULL,-- 职务
department TINYINT(1) NOT NULL,-- 系别
major TINYINT(1) NOT NULL,-- 专业
class TINYINT(1) NOT NULL,-- 班级
stuid INT NOT NULL,-- 学号
buildid TINYINT(1) NOT NULL,-- 楼号
cid TINYINT(1) NOT NULL,-- 层号
sid INT NOT NULL, -- 宿舍号
bedid TINYINT(1) NOT NULL,-- 床号
statu TINYINT(1) NOT NULL, -- 状态值
INDEX (stuname),INDEX(stuid),INDEX(class),INDEX(sid),
 FOREIGN KEY (`department`) REFERENCES `ts_depart` (`id`),
 FOREIGN KEY (`major`) REFERENCES `ts_major` (`id`),
 FOREIGN KEY (`class`) REFERENCES `ts_class` (`id`),
 FOREIGN KEY (`buildid`) REFERENCES `ts_build` (`id`)
)
-- 管理员表
CREATE TABLE ts_admin
(
id INT PRIMARY KEY NOT NULL,
username CHAR(10) NOT NULL,-- 用户名 
passwords CHAR(6) NOT NULL,-- 密码
manage TINYINT(1) NOT NULL,-- 管理权限
INDEX(username),INDEX(passwords)
)

-- 辅导员表
CREATE TABLE ts_fd
(
id INT PRIMARY KEY NOT NULL,
fdname CHAR(10) NOT NULL,-- 辅导员姓名
department TINYINT(1) NOT NULL,-- 系别
phone CHAR(11) NOT NULL ,-- 联系方式 
FOREIGN KEY (`department`) REFERENCES `ts_depart` (`id`)
)

-- 系别表
CREATE TABLE ts_depart
(
 id INT PRIMARY KEY NOT NULL,
 dapatid INT NOT NULL,-- 系别编号
 dapartname CHAR(20) NOT NULL-- 系别名称
)

-- 专业表
CREATE TABLE ts_major
(
id INT PRIMARY KEY NOT NULL,
majorid INT NOT NULL,-- 专业编号
majorname CHAR(30) NOT NULL -- 专业名称
)

-- 班级表
CREATE TABLE ts_class
(
id INT PRIMARY KEY NOT NULL,
classid INT NOT NULL,-- 班级编号
classname CHAR(20) NOT NULL-- 班级名称
)

-- 楼号表
CREATE TABLE ts_build
(
id INT PRIMARY KEY NOT NULL,
ids INT(2) NOT NULL,
pid INT (2) NOT NULL -- 父类id 
)