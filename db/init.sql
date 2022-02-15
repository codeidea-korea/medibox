DROP DATABASE IF EXISTS `medibox`;
CREATE DATABASE `medibox` DEFAULT character set utf8;
USE medibox;

create user 'medibox'@'localhost' identified by 'code0809_';
grant all privileges on medibox.* to 'medibox'@'localhost';

-- 사용자
create table user_info
(
    user_seqno bigint auto_increment
        primary key,
    user_phone    varchar(20)      not null,
    user_pw    varchar(256)      not null,
    user_name    varchar(50)      not null,
    event_yn    varchar(1)      not null default 'N',
    approve_yn    varchar(1)      not null default 'N',
    delete_yn    varchar(1)      not null default 'N',
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index user_info__index_1
    on user_info (user_phone);

-- 사용자 - 포인트, 정액권, 패키지 
create table user_point
(
    user_point_seqno bigint auto_increment
        primary key,
    user_seqno    bigint      not null,
    point_type   varchar(2)      not null, -- P: 포인트, S1-4: 통합/네일/발몽/포레스타 정액권, K: 패키지
    point    int      default 0,
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index user_point__index_1
    on user_point (user_seqno);
-- 사용자 - 포인트/정액권/패키지 사용 내역
create table user_point_hst
(
    user_point_hst_seqno bigint auto_increment
        primary key,
    user_seqno    bigint      not null,
    point_type   varchar(2)      not null, -- P: 포인트, S1-4: 통합/네일/발몽/포레스타 정액권, K: 패키지
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    point    int      default 0,
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index user_point_hst__index_1
    on user_point_hst (user_seqno);
