# [데이터베이스 설계]

코드 깔끔하게 간소화 시켰습니다.
회원가입 로그인 게시판 기능들만 남기고 나머지 다 지웠습니다.

작업해서 각자 branch에 공유해주세요.

## 버전

[Apache Server] : Server version: Apache/2.4.33 (Unix)

[PHP] : PHP 7.2.4 (cli) (built: Apr 13 2018 14:24:35) ( ZTS )
      Copyright (c) 1997-2018 The PHP Group
      Zend Engine v3.2.0, Copyright (c) 1998-2018 Zend Technologies
      
[Mysql] : Ver 14.14 Distrib 5.5.59, for Linux (x86_64) using  EditLine wrapper

## 접속 방법

clone한 파일들을 stack이라는 폴더에 몰아넣고
리눅수 우분투 16.04.4 기준
/usr/local/apache24/htdocs 폴더에 옮기세요

url : localhost/stack/home.php
로 접속하시면 됩니다.

## mysql Database 생성 및 테이블 생성

[명령어 그대로 따라치면 됩니다]
APM설치가 모두 끝나면
mysql접속 : mysql -u root -p

database 확인 : show database;

database 생성 : create stack; (내 코드가 다 stack이라는 데이터베이스 명으로 접속해서 무조건 stack으로 해야함)

database 접속 : use stack;

table 생성 : 

create table board_advertisement (
b_no int unsigned not null primary key auto_increment,
b_title varchar(100) not null,
b_content text not null,
b_date datetime not null,
b_hit int unsigned not null default 0,
b_id varchar(20) not null
)DEFAULT CHARSET=utf8;

create table comment_advertisement(
co_no int unsigned not null primary key auto_increment,
b_no int unsigned not null,
co_order int unsigned default 0,
co_content text not null,
co_id varchar(20) not null
)DEFAULT CHARSET=utf8;

create table session(no int, user_id varchar(15), session_id char(127));

create table user(
no int auto_increment primary key,
 user_id varchar(15) not null, 
user_name varchar(30) not null, 
user_email varchar(30),
user_pw char(50),
user_pw_question varchar(30),
user_pw_answer varchar(30)
)DEFAULT CHARSET=utf8;


이러면 모든 설정 완료

