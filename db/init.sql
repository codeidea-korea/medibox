DROP DATABASE IF EXISTS `medibox`;
CREATE DATABASE `medibox` DEFAULT character set utf8;
USE medibox;

create user 'medibox'@'localhost' identified by 'code0809_';
grant all privileges on medibox.* to 'medibox'@'localhost';

-- 관리자
create table admin_info
(
    admin_seqno bigint auto_increment
        primary key,
    admin_id    varchar(200)      not null,
    admin_pw    varchar(256)      not null,
    admin_name    varchar(50)      not null,
    delete_yn    varchar(1)      not null default 'N',
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index admin_info__index_1
    on admin_info (admin_id);

insert into admin_info (admin_id, admin_pw, admin_name, delete_yn) values ('dev.codeidea@gmail.com','code0809_','Codeidea 개발자','N');
insert into admin_info (admin_id, admin_pw, admin_name, delete_yn) values ('admin','4321','메디박스 관리자','N');

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

-- 포인트(종류) 마스터 테이블
create table point_info
(
    point_seqno bigint auto_increment
        primary key,
    point_type   varchar(2)      not null,
    point_name    varchar(50)      not null,
    delete_yn    varchar(1)      not null default 'N',
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index point_info__index_1
    on point_info (point_type);

insert into point_info (point_type, point_name, delete_yn) values ('P','포인트','N');
insert into point_info (point_type, point_name, delete_yn) values ('K','패키지','N');
insert into point_info (point_type, point_name, delete_yn) values ('S1','통합정액권','N');
insert into point_info (point_type, point_name, delete_yn) values ('S2','네일정액권','N');
insert into point_info (point_type, point_name, delete_yn) values ('S3','발몽정액권','N');
insert into point_info (point_type, point_name, delete_yn) values ('S4','포레스타정액권','N');


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
    admin_seqno    bigint      not null,
    user_seqno    bigint      not null,
    product_seqno    bigint      null,
    point_type   varchar(2)      not null, -- P: 포인트, S1-4: 통합/네일/발몽/포레스타 정액권, K: 패키지, N: 직접 입력
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    admin_name    varchar(50)      null, -- 담당자 명
    refund_point_hst_seqno bigint null, -- 환불 seqno
    point    int      default 0,
    memo   varchar(300)      null, -- 사유
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index user_point_hst__index_1
    on user_point_hst (user_seqno);

-- 상품 가격 정보
create table product
(
    product_seqno bigint auto_increment
        primary key,
    point_type   varchar(2)      not null, -- P: 포인트, S1-4: 통합/네일/발몽/포레스타 정액권, K: 패키지
    type_name   varchar(200)      not null, -- 명칭
    service_name   varchar(200)      not null,
    service_sub_name   varchar(200)      null,
    price    int      default 0,
    return_point    int      default 0,
    offline_type   varchar(1)      not null, -- X: 포인트 상품, O: 샵 상품
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index product__index_1
    on product_hst (point_type);

insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','MINISH SPECIAL', '90분', 300000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','MINISH SPECIAL', '120분', 396000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','하이드레이션', '30분', 136000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','하이드레이션', '60분', 210000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','하이드레이션', '90분', 275000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','하이드레이션', '120분', 440000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','에너지', '30분', 136000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','에너지', '60분', 210000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','에너지', '90분', 275000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','에너지', '120분', 440000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','레디언스', '30분', 150000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','레디언스', '60분', 230000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','레디언스', '90분', 295000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','레디언스', '120분', 460000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','라인&볼륨', '30분', 140000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','라인&볼륨', '60분', 220000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','라인&볼륨', '90분', 285000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','라인&볼륨', '120분', 450000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','마제스티으', '30분', 210000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','마제스티으', '120분', 586000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','소프트&스무드', '30분', 160000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','소프트&스무드', '60분', 240000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','소프트&스무드', '90분', 305000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','소프트&스무드', '120분', 440000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','마더 투 비(임산부)', '60분', 263000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S3', '발몽스파','마더 투 비(임산부)', '90분', 346000, 0);

insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S2', '바라는네일', '베이직케어', null, 100000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S2', '바라는네일', '베이직케어 네일&패디&각질', null, 250000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S2', '바라는네일', '베이직 젤네일&패디젤', null, 250000, 0);

insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S4', '포레스타블랙','CUT', null, 181500, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S4', '포레스타블랙','DRY', null, 121000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S4', '포레스타블랙','PERM', null, 363000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S4', '포레스타블랙','컬러', null, 242000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'S4', '포레스타블랙','두피케어 + 스피드 모발케어', null, 242000, 0);

-- 딥 포커스
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P5', '딥포커스', 'classic', '40분', 100000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P5', '딥포커스', 'luxury', '60분', 200000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P5', '딥포커스', 'special', '120분', 300000, 0);

-- 미니쉬 스파
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P6', '미니쉬 스파', '구강 종합 검진', null, 480000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P6', '미니쉬 스파', '치아튼튼 (4회)', null, 800000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P6', '미니쉬 스파', '잇몸튼튼 (4회)', null, 600000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P6', '미니쉬 스파', '미니쉬플러스 케어 (4회)', null, 600000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P6', '미니쉬 스파', '임플란트플러스 케어 (4회)', null, 400000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P6', '미니쉬 스파', '평생구강건강관리 (회당)', null, 150000, 0);

-- 미니쉬 도수
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P7', '미니쉬 도수', 'classic', '40분', 100000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P7', '미니쉬 도수', 'luxury', '90분', 200000, 0);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 'P7', '미니쉬 도수', 'special', '120분', 350000, 0);


insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'K', '미니쉬 패키지','50만원', null, 500000, 500000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'K', '미니쉬 패키지','100만원', null, 1000000, 1000000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'K', '미니쉬 패키지','150만원', null, 1500000, 1500000);

insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S2', '미니쉬 라운지 정액권','네일 정액권', '100만원', 1000000, 1050000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S2', '미니쉬 라운지 정액권','네일 정액권', '200만원', 2000000, 2200000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S2', '미니쉬 라운지 정액권','네일 정액권', '300만원', 3000000, 3450000);

insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '200만원', 2000000, 2400000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '300만원', 3000000, 3750000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '500만원', 5000000, 6750000);

insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S3', '미니쉬 라운지 정액권','포레스타 정액권', '100만원', 1000000, 1150000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S3', '미니쉬 라운지 정액권','포레스타 정액권', '200만원', 2000000, 2400000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S3', '미니쉬 라운지 정액권','포레스타 정액권', '300만원', 3000000, 3750000);

insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S1', '미니쉬 라운지 정액권','통합 정액권', '300만원', 3000000, 3300000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S1', '미니쉬 라운지 정액권','통합 정액권', '500만원', 5000000, 5750000);
insert into product (offline_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 'S1', '미니쉬 라운지 정액권','통합 정액권', '1000만원', 10000000, 12000000);
