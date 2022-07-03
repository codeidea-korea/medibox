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
    memo    varchar(500)      null, -- 고객 특이사항
    event_yn    varchar(1)      not null default 'N',
    approve_yn    varchar(1)      not null default 'N',
    delete_yn    varchar(1)      not null default 'N',
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index user_info__index_1
    on user_info (user_phone);

-- alter table user_info add column memo varchar(500) null;

alter table user_info add column gender varchar(1) default 'M';
alter table user_info add column recommended_shop varchar(200);
alter table user_info add column recommended_code varchar(100);
alter table user_info add column push_yn    varchar(1)      not null default 'N';
alter table user_info add column email_yn    varchar(1)      not null default 'N';
alter table user_info add column sns_yn    varchar(1)      not null default 'N';

alter table user_info add column naver_id    varchar(300);
alter table user_info add column kakao_id    varchar(300);
alter table user_info add column google_id    varchar(300);

alter table user_info add column email    varchar(300);
alter table user_info add column address    varchar(300);
alter table user_info add column address_detail    varchar(300);
alter table user_info add column grade    varchar(100);
alter table user_info add column type    varchar(100);
alter table user_info add column join_path    varchar(100);

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
    shop_name    varchar(200)      null, -- 상품 대표명 (product_seqno 가 없는 경우)
    product_name    varchar(200)      null, -- 상품 대표명 (product_seqno 가 없는 경우)
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

alter table user_point_hst add column calculate varchar(1) default '+'; -- 포인트 차감자
alter table user_point_hst add column canceled varchar(1) default 'N'; -- hst_type 상태값에 대한 취소 여부 (사용/환불/충전 취소)
alter table user_point_hst add column approved varchar(1) default 'N'; -- 승인 여부

-- 사용자 패키지 구매/환불 가능 여부
create table user_package
(
    user_package_seqno bigint auto_increment
        primary key,
    user_seqno    bigint      not null,
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    allow_refund   varchar(1)      not null, -- 환불가능여부 Y / N
    deleted   varchar(1)      not null, -- 환불처리된, 삭제여부 Y / N
    point    int      default 0,
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

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

    step_type    int      default 0, -- 스텝 그룹 구분 0:없음, 1: 일반 직원급, 2: 실장급, 3: 부원장급, 4: 원장급
    orders    int      default 0, -- 노출 순서
    delete_yn   varchar(1)      not null default 'N', -- 삭제여부

    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- alter table product add column delete_yn varchar(1) default 'N'; 
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'S3', '발몽스파','MINISH SPECIAL', '90분', 300000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'S3', '발몽스파','MINISH SPECIAL', '120분', 450000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 10, 0, 'S3', '발몽스파','하이드레이션', '30분', 140000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 11, 0, 'S3', '발몽스파','하이드레이션', '60분', 210000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 12, 0, 'S3', '발몽스파','하이드레이션', '90분', 280000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 13, 0, 'S3', '발몽스파','하이드레이션', '120분', 440000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 20, 0, 'S3', '발몽스파','에너지', '30분', 140000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 21, 0, 'S3', '발몽스파','에너지', '60분', 210000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 22, 0, 'S3', '발몽스파','에너지', '90분', 280000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 23, 0, 'S3', '발몽스파','에너지', '120분', 440000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 30, 0, 'S3', '발몽스파','레디언스', '30분', 140000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 31, 0, 'S3', '발몽스파','레디언스', '60분', 210000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 32, 0, 'S3', '발몽스파','레디언스', '90분', 280000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 33, 0, 'S3', '발몽스파','레디언스', '120분', 440000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 40, 0, 'S3', '발몽스파','라인&볼륨', '30분', 140000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 41, 0, 'S3', '발몽스파','라인&볼륨', '60분', 210000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 42, 0, 'S3', '발몽스파','라인&볼륨', '90분', 280000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 43, 0, 'S3', '발몽스파','라인&볼륨', '120분', 440000, 0);

-- insert into product (offline_typorders, step_type, e, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y1, 0, ', 'S3', '발몽스파','마제스티으', '30분', 210000, 0);
-- insert into product (offline_typorders, step_type, e, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y1, 0, ', 'S3', '발몽스파','마제스티으', '120분', 586000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 50, 0, 'S3', '발몽스파','MINISH TOUCH', '30분', 160000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 51, 0, 'S3', '발몽스파','MINISH TOUCH', '60분', 240000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 52, 0, 'S3', '발몽스파','MINISH TOUCH', '90분', 350000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 53, 0, 'S3', '발몽스파','MINISH TOUCH', '120분', 460000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 60, 0, 'S3', '발몽스파','마더 투 비(임산부)', '60분', 263000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 61, 0, 'S3', '발몽스파','마더 투 비(임산부)', '90분', 346000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'S2', '바라는네일', '베이직케어', null, 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'S2', '바라는네일', '베이직케어 네일&패디&각질', null, 250000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'S2', '바라는네일', '베이직 젤네일&패디젤', null, 250000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 4, 'S4', '포레스타블랙','CUT-원장', '60분', 181500, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 3, 'S4', '포레스타블랙','CUT-부원장', '60분', 121000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 2, 'S4', '포레스타블랙','CUT-실장', '60분', 108900, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 10, 4, 'S4', '포레스타블랙','DRY-원장', '40분', 121000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 11, 3, 'S4', '포레스타블랙','DRY-부원장', '40분', 108900, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 12, 2, 'S4', '포레스타블랙','DRY-실장', '40분', 96800, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 20, 0, 'S4', '포레스타블랙','PERM', null, 363000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 30, 0, 'S4', '포레스타블랙','컬러', null, 242000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 40, 0, 'S4', '포레스타블랙','두피케어 + 스피드 모발케어', null, 242000, 0);

-- 딥 포커스
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'P5', '딥포커스', 'classic', '40분', 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'P5', '딥포커스', 'luxury', '60분', 200000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'P5', '딥포커스', 'special', '120분', 300000, 0);

-- 미니쉬 스파
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'P6', '미니쉬 스파', '구강 종합 검진', null, 480000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'P6', '미니쉬 스파', '치아튼튼 (4회)', null, 800000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'P6', '미니쉬 스파', '잇몸튼튼 (4회)', null, 600000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 4, 0, 'P6', '미니쉬 스파', '미니쉬플러스 케어 (4회)', null, 600000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 5, 0, 'P6', '미니쉬 스파', '임플란트플러스 케어 (4회)', null, 400000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 6, 0, 'P6', '미니쉬 스파', '평생구강건강관리 (회당)', null, 150000, 0);

-- 미니쉬 도수
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'P7', '미니쉬 도수', 'classic', '40분', 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'P7', '미니쉬 도수', 'luxury', '90분', 350000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'P7', '미니쉬 도수', 'special', '120분', 450000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'K', '미니쉬 패키지','20만원', '패키지', 200000, 200000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'K', '미니쉬 패키지','50만원', '패키지', 500000, 500000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'K', '미니쉬 패키지','100만원', '패키지', 1000000, 1000000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 4, 0, 'K', '미니쉬 패키지','150만원', '패키지', 1500000, 1500000);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'S2', '미니쉬 라운지 정액권','네일 정액권', '100만원', 1000000, 1050000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'S2', '미니쉬 라운지 정액권','네일 정액권', '200만원', 2000000, 2200000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'S2', '미니쉬 라운지 정액권','네일 정액권', '300만원', 3000000, 3450000);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '200만원', 2000000, 2400000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '300만원', 3000000, 3750000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '500만원', 5000000, 6750000);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'S4', '미니쉬 라운지 정액권','포레스타 정액권', '100만원', 1000000, 1150000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'S4', '미니쉬 라운지 정액권','포레스타 정액권', '200만원', 2000000, 2400000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'S4', '미니쉬 라운지 정액권','포레스타 정액권', '300만원', 3000000, 3750000);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'S1', '미니쉬 라운지 정액권','통합 정액권', '300만원', 3000000, 3300000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'S1', '미니쉬 라운지 정액권','통합 정액권', '500만원', 5000000, 5750000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'S1', '미니쉬 라운지 정액권','통합 정액권', '1000만원', 10000000, 12000000);

alter table product add column delete_yn varchar(1) default 'N'; 
update product set delete_yn = 'Y' where product_seqno in (40, 41,42,43,44,45);
update product set delete_yn = 'Y' where product_seqno in (25,26,27);
commit;
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'P6', '미니쉬 스파', 'BASIC', '1시간', 100000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'S2', '바라는네일', '베이직케어-손기본케어', '60분-남자', 48400, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'S2', '바라는네일', '베이직케어-손기본케어', '60분-여자', 36300, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'S2', '바라는네일', '베이직케어-손기본케어', '90분', 72600, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 10, 0, 'S2', '바라는네일', '베이직케어-발기본케어', '60분-남자', 72600, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 11, 0, 'S2', '바라는네일', '베이직케어-발기본케어', '60분-여자', 60500, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 12, 0, 'S2', '바라는네일', '베이직케어-발기본케어', '90분', 121000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 20, 0, 'S2', '바라는네일', '젤-젤네일아트', '90분', 96800, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 30, 0, 'S2', '바라는네일', '젤-젤패디아트', '90분', 121000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 40, 0, 'S2', '바라는네일', '젤-젤제거', '30분', 36300, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 50, 0, 'S2', '바라는네일', '젤-젤아트(네일&패디)', '120분', 121000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 60, 0, 'S2', '바라는네일', '각질관리-각질1단계', '30분', 96800, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 61, 0, 'S2', '바라는네일', '각질관리-각질2단계', '40분', 133100, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 62, 0, 'S2', '바라는네일', '각질관리-각질3단계', '50분', 169400, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 63, 0, 'S2', '바라는네일', '각질관리-각질4단계', '60분', 217800, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 70, 0, 'S2', '바라는네일', '문제성 특수관리-물어뜯는손톱', '120분', 193600, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 80, 0, 'S2', '바라는네일', '문제성 특수관리-파고드는발톱', '100분-1ea', 181500, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 81, 0, 'S2', '바라는네일', '문제성 특수관리-파고드는발톱', '100분-2ea', 242000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 82, 0, 'S2', '바라는네일', '문제성 특수관리-파고드는발톱', '120분-1ea', 240900, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 83, 0, 'S2', '바라는네일', '문제성 특수관리-파고드는발톱', '120분-2ea', 350900, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 90, 0, 'S2', '바라는네일', '멤버쉽서비스-베이직케어', '90분', 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 91, 0, 'S2', '바라는네일', '멤버쉽서비스-베이직케어/네일+패디+각질', '120분', 250000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 92, 0, 'S2', '바라는네일', '멤버쉽서비스-베이직젤네일+젤패디', '180분', 250000, 0);

commit;

UPDATE `medibox`.`product` SET `type_name` = 'BASIC-포커스 비전케어' WHERE (`product_seqno` = '37');
UPDATE `medibox`.`product` SET `type_name` = 'LUXURY-딥포커스 비전케어' WHERE (`product_seqno` = '38');
UPDATE `medibox`.`product` SET `type_name` = 'SPECIAL-딥포커스 아이테라피' WHERE (`product_seqno` = '39');

UPDATE `medibox`.`product` SET `delete_yn` = 'Y' WHERE (`product_seqno` = '46');
UPDATE `medibox`.`product` SET `delete_yn` = 'Y' WHERE (`product_seqno` = '47');
UPDATE `medibox`.`product` SET `delete_yn` = 'Y' WHERE (`product_seqno` = '48');

UPDATE `medibox`.`product` SET `type_name` = 'BAISIC-미니쉬 스파' WHERE (`product_seqno` = '65');
UPDATE `medibox`.`product` SET `service_sub_name` = '180분' WHERE (`product_seqno` = '34');
UPDATE `medibox`.`product` SET `service_sub_name` = '120분' WHERE (`product_seqno` = '35');
UPDATE `medibox`.`product` SET `service_sub_name` = '90분' WHERE (`product_seqno` = '36');

INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('3', 'admin1', '4321!!', '메디박스 관리자1', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('4', 'admin2', '4321@@', '메디박스 관리자2', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('5', 'admin3', '4321##', '메디박스 관리자3', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('6', 'admin4', '4321$$', '메디박스 관리자4', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('7', 'admin5', '4321%%', '메디박스 관리자5', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('8', 'admin6', '4321**', '메디박스 관리자6', 'N');

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'P6', '미니쉬 스파', 'BASIC', '1시간-4회', 300000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 10, 0, 'P6', '미니쉬 스파', 'LUXURY-건치백세 패키지', '1시간-1회', 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 11, 0, 'P6', '미니쉬 스파', 'LUXURY-건치백세 패키지', '1시간-2회', 150000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 12, 0, 'P6', '미니쉬 스파', 'LUXURY-건치백세 패키지', '1시간-4회', 300000, 0);

commit;



alter table admin_info add column admin_type varchar(1) default 'A'; -- A 최고관리자, P 제휴사
-- 브랜드 관리
drop table partner;
create table partner
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null, -- 등록 관리자

    cop_name   varchar(200)      not null, 
    cop_no   varchar(20)      not null, 
    cop_file   varchar(200)      null, 
    cop_phone    varchar(20)      null,
    online_order_business_no   varchar(30)      not null, 
    online_order_business_file   varchar(200)      null, 

    director_name   varchar(200)      not null, 
    director_phone    varchar(20)      null,
    director_email    varchar(50)      null,
    director_seqno bigint not null, -- admin_seqno 제휴 관리자.

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 매장 정보 관리
drop table store;
create table store
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null, -- 등록 관리자
    partner_seqno    bigint      null,
    name   varchar(200)      not null, 
    phone    varchar(20)      null,
    address    varchar(300)      null,
    address_detail    varchar(300)      null,
    zipcode    varchar(7)      null,
    info   text      null, 
    img1    varchar(200)      null,
    img2    varchar(200)      null,
    img3    varchar(200)      null,
    img4    varchar(200)      null,
    img5    varchar(200)      null,
    in_manager   varchar(1)      not null, -- 매니저 예약 여부 Y / N
    manager_type   text      null, -- 매니저 구분 (list { 원장,매니저 })
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (예약) 매장별 매니저 정보
create table store_manager
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null, -- 등록 관리자
    partner_seqno    bigint      null,
    store_seqno    bigint      null,
    manager_type varchar(20)      null, -- 매니저 구분
    name   varchar(200)      not null, 
    use_img   varchar(1)      not null, -- 매니저 사진 사용 여부
    img1    varchar(200)      null,
    img2    varchar(200)      null,
    img3    varchar(200)      null,
    img4    varchar(200)      null,
    img5    varchar(200)      null,
    memo varchar(500) null,
    -- 근로 시작-종료 시간
    start_dt    varchar(5)      null,
    end_dt    varchar(5)      null,
    -- 입사일/퇴사일
    join_dt        datetime         null,
    unjoin_dt        datetime         null,
    -- 휴일 매핑 시퀀스
    holiday_type   varchar(1)      not null, -- 매장에 따를지, 개별로 만들지
    visible   varchar(1)      not null, -- 노출/비노출

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (매장/디자이너) 매장별 매니저 등급별 서비스
create table store_service
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null, -- 등록 관리자
    partner_seqno    bigint      null,
    store_seqno    bigint      null,
    manager_type varchar(20)      null, -- 매니저 구분
    -- 분류 추가
    name   varchar(200)      not null, 
    estimated_time   varchar(5)      null, -- 예상 소요시간 00:00
    price    int      default 0,
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (매장/디자이너) 휴일 설정
create table holiday
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null, -- 등록 관리자
    store_seqno    bigint      null, -- 매장 식별구분
    manager_seqno    bigint      null, -- 매니저 식별구분
    holiday_dt        datetime         null,
    create_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- (예약) 고객-매장 매니저 예약 정보
drop table reservation;
create table reservation
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      null, -- 
    partner_seqno bigint not null, -- 해당 제휴사
    store_seqno    bigint      not null, -- 해당 매장
    manager_seqno    bigint      null, -- 해당 디자이너 (없는 매장도 있음)
    user_seqno    bigint      not null, -- 등록 고객
    service_seqno    bigint      not null, -- 서비스
    status   varchar(1)      not null, -- 예약 상태 (Reservation 예약완료, user-do-Not-entered 예약불이행, Cancel 예약취소, user-Entered 고객입장, Done 서비스완료)
    -- 아이콘 표기 여부
    use_icon_important   varchar(1)      not null, -- 중요고객 여부 Y / N
    use_icon_phone   varchar(1)      not null, -- 전화표기 여부 Y / N
    use_custom_color   varchar(1)      not null, -- 색상선택 여부 Y / N
    -- 
    custom_color   varchar(7)      null, -- #000000
    estimated_time   varchar(5)      null, -- 예상 소요시간 00:00
    start_dt        datetime  not null,

    memo varchar(500) null,
    apply_on_mobile   varchar(1)      not null, -- 현장/모바일 등록 여부

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;


drop table reservation_product_grp;
create table reservation_product_grp
(
    seqno bigint auto_increment primary key,
    reservation_seqno    bigint      not null, -- 
    product_seqno bigint not null, -- 

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (예약) 환경 설정

drop table reservation_config;
create table reservation_config
(
    seqno bigint auto_increment primary key,
    partner_seqno bigint not null, -- 해당 제휴사
    store_seqno    bigint      not null, -- 해당 매장

    product_seqno bigint not null, -- 

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (예약) 문의
drop table reservation_counsel;
create table reservation_counsel
(
    seqno bigint auto_increment primary key,
    partner_seqno bigint not null, -- 해당 제휴사
    store_seqno    bigint      not null, -- 해당 매장
    user_seqno    bigint      not null, -- 해당 매장
    
    question text null, -- 
    answer text null, -- 
    answered   varchar(1)      not null, -- 답변 여부 Y / N

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- (쿠폰) 쿠폰
drop table coupon;
create table coupon
(
    seqno bigint auto_increment
        primary key,
    -- 적용 제휴사 그룹 (0이면 전부 적용)
    coupon_partner_grp_seqno varchar(200) null, -- 해당 제휴사
    name   varchar(200)      not null, -- 쿠폰명
    context   varchar(200)      null, -- 쿠폰 내용
    issuance_type   varchar(1)      not null, -- 지급유형 (A 자동 지급)
    issuance_condition_type   varchar(1)      not null, -- 지급 조건 구분 (A 전체발급, J 회원가입시, M 멤버쉽)
    -- 쿠폰 사용기간
    start_dt        datetime  not null,
    end_dt        datetime  not null,
    type   varchar(1)      not null, -- 쿠폰 유형 (F 정액, P 정률, G 경품-지급)
    discount_price int not null,
    max_discount_price int not null, -- 0인 경우 무제한
    limit_base_price int not null, -- 최소 기준금액 (0인 경우 제한 없음)
    allowed_issuance_type   varchar(1)      not null, -- 발급 허용 상태 (A 발급중, C 발급중지, E 발급종료)

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (쿠폰) 쿠폰-적용할 파트너 그룹
drop table coupon_partner_grp;
create table coupon_partner_grp
(
    seqno bigint auto_increment
        primary key,
    coupon_seqno bigint not null, 
    partner_seqno bigint not null, 

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (쿠폰) 쿠폰-사용자 발급 현황
drop table coupon_user;
create table coupon_user
(
    seqno bigint auto_increment
        primary key,
    coupon_seqno bigint not null, 
    user_seqno bigint not null, 

    used   varchar(1)      not null, -- 사용완료 여부 Y / N (미사용 쿠폰중 기간이 도래하면 기간만료)
    -- 쿠폰 사용기간
    real_start_dt        datetime  not null,
    real_end_dt        datetime  not null,
    real_discount_price int not null, -- 혜택 금액 (실제 할인된 금액)

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- (상품) 포인트 관리 (존재)
-- (상품) 정액권 관리 (존재)
-- (상품) 패키지 관리 (존재)

-- (멤버쉽) 멤버쉽 관리
drop table product_membership;
create table product_membership
(
    seqno bigint auto_increment
        primary key,
    admin_seqno    bigint      not null,
    name   varchar(200)      not null,
    price   int      not null, -- 오프라인 가격
    date_use   int      not null, -- 제한 주 (0 이면 무한)

    point    int      default 0, -- 부여 포인트

    deleted   varchar(1)      not null, -- 환불처리된, 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (멤버쉽) 바우처 관리
drop table product_voucher;
create table product_voucher
(
    seqno bigint auto_increment
        primary key,
    admin_seqno    bigint      not null,
    name   varchar(200)      not null,
    context   varchar(200)      null,
    unit_count    int      default 0, -- 발급 수량
    date_use   int      not null, -- 제한 주 (0 이면 무한)

    use_partner   varchar(1)      not null, -- 제휴사 연결 여부 Y / N
    partner_seqno bigint null, -- 해당 제휴사
    store_seqno    bigint      null, -- 해당 매장
    service_seqno    bigint      null, -- 해당 서비스

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 바우처 메인
drop table membership_service_grp;
create table membership_service_grp
(
    seqno bigint auto_increment
        primary key,
    membership_seqno    bigint      not null,
    service_seqno    bigint      not null,
    unit_count    int      not null,
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 바우처 기타 (서브 바우처)
drop table membership_etc_voucher_grp;
create table membership_etc_voucher_grp
(
    seqno bigint auto_increment
        primary key,
    membership_seqno    bigint      not null,
    etc_voucher_seqno    bigint      not null,
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 쿠폰
drop table membership_coupon_grp;
create table membership_coupon_grp
(
    seqno bigint auto_increment
        primary key,
    membership_seqno    bigint      not null,
    coupon_seqno    bigint      not null,
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- 멤버쉽 사용 내역 (쿠폰/바우처/멤버쉽 통합되어 있는데 분리해서 짜야됨)
-- product_membership_hst
-- coupon_user

alter table coupon_user add column membership_seqno bigint      null;
alter table coupon_user add column hst_type varchar(1)      not null;

drop table voucher_user;
create table voucher_user
(
    seqno bigint auto_increment
        primary key,
    membership_seqno    bigint      null, -- 멤버쉽에서 들어온 쿠폰의 경우
    voucher_seqno    bigint      not null,
    user_seqno    bigint      not null,
    used   varchar(1)      not null, -- 사용완료 여부 Y / N (미사용 쿠폰중 기간이 도래하면 기간만료)
    approved varchar(1)      not null, -- 승인 여부
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- 매핑 
drop table membership_user;
create table membership_user
(
    seqno bigint auto_increment
        primary key,
    membership_seqno    bigint     not null, -- 
    user_seqno    bigint      not null,
    used   varchar(1)      not null, -- 사용완료 여부 Y / N (미사용 쿠폰중 기간이 도래하면 기간만료)
    approved varchar(1)      not null, -- 승인 여부
    real_start_dt        datetime  not null,
    real_end_dt        datetime  not null,
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- hst
drop table membership_user_hst;
create table membership_user_hst
(
    seqno bigint auto_increment
        primary key,
    membership_user_seqno    bigint     not null,
    service_seqno    bigint      null, -- 서비스를 사용했으면
    voucher_seqno    bigint      null, -- 바우처를 사용했으면
    coupon_seqno    bigint      null, -- 쿠폰을 사용했으면
    product_name    varchar(200)      null, -- 미등록 상품을 소비했으면
    user_seqno    bigint      not null,
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    create_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- 관리자 히스토리 (나중에)
drop table admin_action_hst;
create table admin_action_hst
(
    seqno bigint auto_increment
        primary key,
    admin_seqno    bigint      not null,
    menu_name   varchar(200)      not null, -- 메뉴
    action   varchar(10)      not null, -- action
    ip   varchar(15)      not null, -- IP
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 컨텐츠 관리 (나중에)
-- (컨텐츠) 사용자 공지사항 (제목/내용/순서)
drop table user_notice;
create table user_notice
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    ordered   int      not null, -- 노출순서
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 파트너 공지사항 (제목/내용/순서)
drop table partner_notice;
create table partner_notice
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    ordered   int      not null, -- 노출순서
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 자주묻는질문
drop table faq;
create table faq
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    ordered   int      not null, -- 노출순서
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 도움말
drop table cont_help;
create table cont_help
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    ordered   int      not null, -- 노출순서
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 이용약관
drop table cont_usage;
create table cont_usage
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 개인정보처리방침
drop table cont_privacy;
create table cont_privacy
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 배너관리
drop table banner;
create table banner
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, -- 배너명
    thumbnail   varchar(300)      not null, -- 배너 썸네일
    link   varchar(300)      not null, -- 이동할 링크
    contents   text      not null, 
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 사용자 템플릿 선택

drop table template;
create table template
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    file_name   varchar(200)      not null, -- 메인화면 url
    representative_img   varchar(200)      not null, -- 대표이미지 url
    choosed   varchar(1)      not null, -- 선택 여부 Y / N
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

insert into template (admin_seqno, file_name, representative_img, choosed, deleted) values (0, 'main2', '/adm/img/template/temp01.png', 'Y', 'N');
insert into template (admin_seqno, file_name, representative_img, choosed, deleted) values (0, 'main3', '/adm/img/template/temp02.png', 'N', 'N');
insert into template (admin_seqno, file_name, representative_img, choosed, deleted) values (0, 'main4', '/adm/img/template/temp03.png', 'N', 'N');

INSERT INTO `medibox`.`partner` (`admin_seqno`, `cop_name`, `cop_no`, `cop_phone`, `online_order_business_no`, `director_name`, `director_phone`, `director_seqno`, `deleted`) VALUES ('0', '미니쉬 스파', '000-0-0000', '010-0000-0000', '통-0000-0-0000', '홍길동1', '010-1234-1234', '0', 'N');
INSERT INTO `medibox`.`partner` (`admin_seqno`, `cop_name`, `cop_no`, `cop_phone`, `online_order_business_no`, `director_name`, `director_phone`, `director_seqno`, `deleted`) VALUES ('0', '발몽 스파', '000-0-0000', '010-0000-0000', '통-0000-0-0000', '홍길동2', '010-1234-1234', '0', 'N');
INSERT INTO `medibox`.`partner` (`admin_seqno`, `cop_name`, `cop_no`, `cop_phone`, `online_order_business_no`, `director_name`, `director_phone`, `director_seqno`, `deleted`) VALUES ('0', '바라는 네일', '000-0-0000', '010-0000-0000', '통-0000-0-0000', '홍길동3', '010-1234-1234', '0', 'N');
INSERT INTO `medibox`.`partner` (`admin_seqno`, `cop_name`, `cop_no`, `cop_phone`, `online_order_business_no`, `director_name`, `director_phone`, `director_seqno`, `deleted`) VALUES ('0', '딥포커스 검안센터', '000-0-0000', '010-0000-0000', '통-0000-0-0000', '홍길동4', '010-1234-1234', '0', 'N');
INSERT INTO `medibox`.`partner` (`admin_seqno`, `cop_name`, `cop_no`, `cop_phone`, `online_order_business_no`, `director_name`, `director_phone`, `director_seqno`, `deleted`) VALUES ('0', '미니쉬 도수', '000-0-0000', '010-0000-0000', '통-0000-0-0000', '홍길동5', '010-1234-1234', '0', 'N');
INSERT INTO `medibox`.`partner` (`admin_seqno`, `cop_name`, `cop_no`, `cop_phone`, `online_order_business_no`, `director_name`, `director_phone`, `director_seqno`, `deleted`) VALUES ('0', '포레스타 블랙', '000-0-0000', '010-0000-0000', '통-0000-0-0000', '홍길동6', '010-1234-1234', '0', 'N');




alter table store_service add column dept    varchar(300) default '';
alter table reservation add column user_name    varchar(30) default '';
alter table reservation add column user_phone    varchar(30) default '';

-- 영업시간 10 - 12, 월화수목금토일 지정, 점심시간 12-14, 점심시간 예약접수여부
-- 매장별 영업시간 조정
alter table store add column start_dt    varchar(5) default '09:00';
alter table store add column end_dt    varchar(5) default '18:00';
alter table store add column due_day    varchar(50) default '1,2,3,4,5,6,0';
-- 매장별 점심시간 조정
alter table store add column lunch_start_dt    varchar(5) default '12:00';
alter table store add column lunch_end_dt    varchar(5) default '13:00';
alter table store add column allow_lunch_reservate    varchar(1) default 'N';
-- 매장별 특수 휴일 사용 여부
alter table store add column allow_ext_holiday    varchar(1) default 'N';
alter table store add column ext_holiday_weekly    varchar(1) default ''; -- 매주 특정 요일 휴무 지정 
alter table store add column ext_holiday_weekend_day    varchar(5) default ''; -- 매월 해당주 특정 요일 휴무 지정 (3주 월요일 = 3-1)
alter table store add column ext_holiday_montly    varchar(100) default ''; -- 매월 지정일 휴무 ()

-- 개별 휴일 설정 (holiday)


-- 제휴사 영문명, 배경 이미지, 매장아이콘, 내용
-- 매장 소개
alter table partner add column cop_eng_name  varchar(200) default '';
alter table partner add column background_img  varchar(200) default '';
alter table partner add column icon_reservation_store  varchar(200) default ''; -- 제휴 매장 대표 아이콘
alter table partner add column info  text;

alter table store add column info  text;

UPDATE `medibox`.`partner` SET `cop_eng_name` = 'MINISH Dental Spa', `background_img` = '/user/img/img_brand01.png', `icon_reservation_store` = '/user/img/icon_minish_spa.svg', `info` = '<p>‘나 자신도 몰랐던 입속 상태를 정확히 진단받고, 건강한 구강 관리가 가능토록 미니쉬가 만들었습니다.’</p>' WHERE (`seqno` = '1');
UPDATE `medibox`.`partner` SET `cop_eng_name` = 'MINISH Valmont Spa', `background_img` = '/user/img/img_brand02.png', `icon_reservation_store` = '/user/img/icon_valmont_spa.svg', `info` = '<p>스위스 발몽 코스메틱의 기술력과 미니쉬가 만나 우리의 고객이 건강하게 아름다워질 수 있도록 합니다.</p>' WHERE (`seqno` = '2');
UPDATE `medibox`.`partner` SET `cop_eng_name` = 'Tomorrow’s wish', `background_img` = '/user/img/img_brand03.png', `icon_reservation_store` = '/user/img/icon_nail.svg', `info` = '<p>바라는 네일의 네일룸과 패디룸의 모든 공간은 고객님의 편안한 휴식 시간을 온전히 즐기실 수 있도록 준비되어있습니다. 바라는 네일에 들어오시는 순간부터 나가실 때까지 고객님 한분한분을 위한 맞춤관리로 프라이빗한 프리미엄 관리를 경험하실 수 있습니다.</p>' WHERE (`seqno` = '3');
UPDATE `medibox`.`partner` SET `cop_eng_name` = 'Deep Focus', `background_img` = '/user/img/img_brand04.png', `icon_reservation_store` = '/user/img/icon_deep_focus.svg', `info` = '<p>‘왜 유럽과 미국에서는 보편화된 전문 검안을 한국에서는 찾아보기 어려울까?’ 이런 의문으로 시작한 딥포커스 정밀 검안센터는 ‘김광용 OPTICIAN’에 의해 15년 동안 연구된 눈 중심 전문 검안센터입니다.</p>' WHERE (`seqno` = '4');
UPDATE `medibox`.`partner` SET `cop_eng_name` = 'MINISH Manual Therapy', `background_img` = '/user/img/img_brand05.png', `icon_reservation_store` = '/user/img/icon_foresta_black.svg', `info` = '<p>‘MANUAL THERAPY’, 모든 인체의 건강은 예방관리가 가장 중요합니다. 호감가는 인상을 결정하는 것은 이목구비 뿐 아니라 체형도 중요한 요인이 됩니다. 일상생활 속 잘못된 자세가 반복되면 그 사람의 체형으로 고착화됩니다.</p>' WHERE (`seqno` = '5');
UPDATE `medibox`.`partner` SET `cop_eng_name` = 'Foresta Black', `background_img` = '/user/img/img_brand06.png', `icon_reservation_store` = '/user/img/icon_minish_manul_therapy.svg', `info` = '<p>국내 최초이자 유일한 아베다의 뷰티 최상 등급인 라이프 스타일 살롱 ‘포레스타 블랙’</p>' WHERE (`seqno` = '6');

alter table partner add column slide_img_01  varchar(200) default '';
alter table partner add column slide_img_02  varchar(200) default '';
alter table partner add column slide_img_03  varchar(200) default '';
alter table partner add column slide_img_04  varchar(200) default '';
alter table partner add column slide_img_05  varchar(200) default '';

UPDATE `medibox`.`partner` SET `slide_img_01` = '/user/img/minish_spa01.jpg' WHERE (`seqno` = '1');
UPDATE `medibox`.`partner` SET `slide_img_01` = '/user/img/valmont_spa01.jpg' WHERE (`seqno` = '2');
UPDATE `medibox`.`partner` SET `slide_img_01` = '/user/img/nail01.jpg' WHERE (`seqno` = '3');
UPDATE `medibox`.`partner` SET `slide_img_01` = '/user/img/deep_focus01.jpg' WHERE (`seqno` = '4');
UPDATE `medibox`.`partner` SET `slide_img_01` = '/user/img/minish_manul_therapy01.jpg' WHERE (`seqno` = '5');
UPDATE `medibox`.`partner` SET `slide_img_01` = '/user/img/foresta_black01.jpg' WHERE (`seqno` = '6');

UPDATE `medibox`.`partner` SET `info` = '<p>‘나 자신도 몰랐던 입속 상태를 정확히 진단받고, 건강한 구강 관리가 가능토록 미니쉬가 만들었습니다.’</p><p>미니쉬 스파에서는 구강질환이 발생하지 않도록 예방하고 이미 발생한 구강질환은 비침습적 방법으로 관리할 수 있도록 개인별 구강 상태에 맞는 관리 프로그램을 진행해드립니다. 최첨단 의료 장비를 통해 구강질환의 원인 세균에 대한 분석, 전문가의 섬세한 손길을 통해 체계적인 구강 관리를 원하시는 분들께 추천하고 있습니다.</p>' WHERE (`seqno` = '1');
UPDATE `medibox`.`partner` SET `info` = '<p>스위스 발몽 코스메틱의 헤리티지와 미니쉬의 만남! 코코 샤넬, 찰리 채플린, 소피아 로렌 등 세계적인 유명인사들의 피부 재생 치료로 유명세를 탔던 발몽 클리닉. 1985년 그 병원 이름을 따 ‘발몽’이라는 화장품 브랜드가 탄생됐습니다. 스위스 천연 자원으로 만들어진 발몽 제품과 발몽 테크닉을 이용하여 얼굴 피부와 전신에 스며들게 합니다. 발몽의 노하우를 전수받은 숙련된 테라피스트가 함께하여, 당신의 아름다움을 되찾아 드립니다. 편안한 휴식을 위한 1인 1룸, 청결한 위생을 위한 1인 1시트, 체계적인 분석과 정밀한 진단을 통한 트리트먼트로 오직 고객만을 위한 시간과 공간을 선사합니다. 발몽스파에서 지금 바로 실현해보세요.</p>' WHERE (`seqno` = '2');
UPDATE `medibox`.`partner` SET `info` = '<p>바라는 네일의 네일룸과 패디룸의 모든 공간은 고객님의 편안한 휴식 시간을 온전히 즐기실 수 있도록 준비되어있습니다. 바라는 네일에 들어오시는 순간부터 나가실 때까지 고객님 한분한분을 위한 맞춤관리로 프라이빗한 프리미엄 관리를 경험하실 수 있습니다.</p><p>파고드는 발톱관리 & 문제성 손발톱관리 & 물어뜯는 손톱관리 & 문제성 각질프리미엄 관리를 함께 만나실 수 있습니다.</p><p>고객님의 맞춤관리로 네일과 패디관리뿐만 아니라 휴식과 편안함을 즐기실 수 있는 공간을 제공해드립니다.</p>' WHERE (`seqno` = '3');
UPDATE `medibox`.`partner` SET `info` = '<p>‘검안에 눈뜨다’ 더 선명한 세상을 마주하는 DEEP FOCUS ‘유럽과 미국엔 보편화된 전문 검안 센터, 왜 한국에선 찾기 어려울까?’ ‘김광용 OPTICIAN’이 15여 년간 연구한 눈 중심 전문 검안 센터는 이처럼 간단한 질문에서 출발하였습니다.</p><p>익숙한듯 당연하지만, 하루하루 눈의 쓰임새는 정말 중요합니다. 특정 질환이 아니더라도 다양한 불편 증상이 생길 수 있습니다. 때문에 눈 질환과 시기능 이상은 구별이 필요합니다.</p><p>우리의 눈은 세상을 보고, 사랑하는 이의 눈을 마주하기도 합니다. 정밀하고 체계적인 검안 시스템을 갖춘 딥포커스에서 더욱 선명해질 당신의 시선을 약속합니다.</p>' WHERE (`seqno` = '4');
UPDATE `medibox`.`partner` SET `info` = '<p>‘MANUAL THERAPY’, 모든 인체의 건강은 예방관리가 가장 중요합니다. 호감가는 인상을 결정하는 것은 이목구비 뿐 아니라 체형도 중요한 요인이 됩니다. 일상생활 속 잘못된 자세가 반복되면 그 사람의 체형으로 고착화됩니다.</p><p>미니쉬 도수에서는 관절 전문 병원 출신의 물리치료사의 체형교정 서비스를 제공하고 근골격의 변형예측, 근육 형상 검사가 가능한 장비를 활용한 검사 결과에 따라 개개인에 맞는 자가운동 치료 솔루션을 처방해드립니다. </p><p>멤버십 고객분들을 위한 미니쉬라운지청담만의 특별한 매뉴얼 테라피를 경험해보기시 바랍니다.</p>' WHERE (`seqno` = '5');
UPDATE `medibox`.`partner` SET `info` = '<p>국내 최초이자 유일한 아베다의 뷰티 최상 등급인 라이프 스타일 살롱 ‘포레스타 블랙’</p><p>환경, 웰빙, 아름다움을 실천하는 아베다의 철학을 선보이며, 대표적인 친환경 브랜드인 아베다의 유기농 헤어 제품만을 사용하는 것을 원칙으로 합니다. 각 분야의 최고 전문가들이 특별한 여러분들을 위한 토탈 뷰티 서비스를 제공합니다. 아름다움을 위한 공간일 뿐만 아니라 도심 속 편안한 휴식 공간으로서, 내,외적인 균형을 통한 진정한 아름다움을 가꾸어 드립니다.</p>' WHERE (`seqno` = '6');


UPDATE `medibox`.`store` SET `info` = '안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.안녕하세요!.', `img1` = '/user/img/minish_spa01.jpg', `img2` = '/user/img/minish_spa02.jpg', `img3` = '/user/img/minish_spa03.jpg', `start_dt` = '11:00', `end_dt` = '16:00', `allow_ext_holiday` = 'D', `ext_holiday_montly` = '5,10,17' WHERE (`seqno` = '2');
UPDATE `medibox`.`store` SET `info` = '안녕하세요!.테스트입니다.안녕하세요!.테스트입니다.안녕하세요!.테스트입니다.안녕하세요!.테스트입니다.안녕하세요!.테스트입니다.안녕하세요!.테스트입니다.', `img1` = '/user/img/valmont_spa01.jpg', `img2` = '/user/img/valmont_spa02.jpg', `allow_ext_holiday` = 'W', `ext_holiday_weekly` = '4' WHERE (`seqno` = '3');



-- (포인트) 포인트 자동 적립관리
drop table conf_auto_point;
create table conf_auto_point
(
    join_bonus   varchar(1)      not null, -- 회원가입 포인트 사용여부 Y / N
    join_bonus_point    int      not null default 0,
    recommand_bonus   varchar(1)      not null, -- 추천인 포인트 사용여부 Y / N
    recommand_bonus_point    int      not null default 0,
    recommand_bonus_rate    int      not null default 0,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

INSERT INTO `medibox`.`conf_auto_point` (`join_bonus`, `join_bonus_point`, `recommand_bonus`, `recommand_bonus_point`, `recommand_bonus_rate`) VALUES ('N', 0, 'Y', 0, 2);


-- 제휴사 service_name
-- 이름 type_name
-- 내용
-- 가격 price
-- 적립 포인트율 
-- 포인트 return_point
-- 사용 기간 
alter table product add column info varchar(200) default '';
alter table product add column add_rate int default 0;
alter table product add column date_use int default 14;


alter table partner add column main_line_sentence varchar(300) default '';
UPDATE `medibox`.`partner` SET `main_line_sentence` = '미니쉬 치과 병원 구강관리 SPA 1:1<br>맞춤 관리 및 코칭 서비스' WHERE (`seqno` = '1');
UPDATE `medibox`.`partner` SET `main_line_sentence` = '미니쉬발몽스파 스페셜 테라피' WHERE (`seqno` = '2');
UPDATE `medibox`.`partner` SET `main_line_sentence` = '1:1 관리 예약 우선제 / 전문적인 케어' WHERE (`seqno` = '3');
UPDATE `medibox`.`partner` SET `main_line_sentence` = '기존 뉴욕스토리안경원의<br>프리미엄 검안 전문체' WHERE (`seqno` = '4');
UPDATE `medibox`.`partner` SET `main_line_sentence` = '전문교육을 이수한 도수 치료사가 손을<br>이용하여 시행하는 프리미엄 물리치료' WHERE (`seqno` = '5');
UPDATE `medibox`.`partner` SET `main_line_sentence` = '국내 최초이자 유일한 아베다의 뷰티<br>최상 등급 라이프 살롱' WHERE (`seqno` = '6');

UPDATE `medibox`.`store` SET `img1` = '/user/img/nail01.jpg' WHERE (`seqno` = '1');
UPDATE `medibox`.`store` SET `img1` = '/user/img/minish_spa01.jpg' WHERE (`seqno` = '2');
UPDATE `medibox`.`store` SET `img1` = '/user/img/valmont_spa01.jpg' WHERE (`seqno` = '3');
UPDATE `medibox`.`store` SET `img1` = '/user/img/deep_focus01.jpg' WHERE (`seqno` = '4');
UPDATE `medibox`.`store` SET `img1` = '/img/foresta_black01.jpg' WHERE (`seqno` = '5');
UPDATE `medibox`.`store` SET `img1` = '/user/img/minish_manul_therapy01.jpg' WHERE (`seqno` = '6');

-- point_type (P:포인트, K:패키지, S:정액권)
/*
alter table product add column partner_seqno bigint null; -- 기존 point_type에서 제휴사 구분하던 부분을 seq 로 분리

update product set point_type = 'SX', partner_seqno = (SELECT seqno FROM medibox.partner where cop_name = '바라는 네일') where point_type = 'S2';
update product set point_type = 'SX', partner_seqno = (SELECT seqno FROM medibox.partner where cop_name = '발몽 스파') where point_type = 'S3';
update product set point_type = 'SX', partner_seqno = (SELECT seqno FROM medibox.partner where cop_name = '포레스타 블랙') where point_type = 'S4';
update product set point_type = 'SX', partner_seqno = (SELECT seqno FROM medibox.partner where cop_name = '딥포커스') where point_type = 'S5';
update product set point_type = 'SX', partner_seqno = (SELECT seqno FROM medibox.partner where cop_name = '미니쉬 스파') where point_type = 'S6';
update product set point_type = 'SX', partner_seqno = (SELECT seqno FROM medibox.partner where cop_name = '미니쉬 도수') where point_type = 'S7';
*/


-- 레벨권한 설정 (나중에)
alter table admin_info add column store_seqno bigint null; -- 소속 지점
alter table admin_info add column admin_type varchar(1) null; -- A:슈퍼관리자, B:본사관리자, P:브랜드 관리자, S:숍(매장별)관리자
alter table admin_info add column level_partner_grp_seqno varchar(200) null; -- 관리자 권한 제휴사 리스트


alter table user_point_hst add column service_seqno bigint null;


-- (쿠폰) 이벤트 쿠폰
drop table even_coupon;
create table even_coupon
(
    seqno bigint auto_increment
        primary key,
    name   varchar(200)      not null, -- 쿠폰명
    context   text      null, -- 쿠폰 내용
    -- 쿠폰 정보
    coupon_partner_grp_seqno varchar(200) null, -- 해당 제휴사
    -- 쿠폰 사용기간
    start_dt        datetime  not null,
    end_dt        datetime  not null,
    type   varchar(1)      not null, -- 쿠폰 유형 (F 정액, P 정률, G 경품-지급)
    discount_price int not null,
    max_discount_price int not null, -- 0인 경우 무제한
    limit_base_price int not null, -- 최소 기준금액 (0인 경우 제한 없음)
    allowed_issuance_type   varchar(1)      not null, -- 발급 허용 상태 (A 발급중, C 발급중지, E 발급종료)

    event_banner_seqno bigint null, -- 이벤트 배너 식별자 1:1 (추후 1:n 확장시 매핑 테이블 별도 구현 필요)

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (쿠폰) 이벤트 배너
drop table even_banner;
create table even_banner
(
    seqno bigint auto_increment
        primary key,
    name   varchar(200)      not null, -- 이벤트명
    context   text      null, -- 이벤트명 내용
    thumbnail   varchar(300)      null, -- 썸네일
    img   varchar(300)      null, -- 이미지
    start_dt        datetime  not null,
    end_dt        datetime  not null,
    used_coupon   varchar(1)      not null, -- 쿠폰 사용 유무

    event_coupon_seqno bigint null, -- 이벤트 쿠폰 식별자 1:1 (추후 1:n 확장시 매핑 테이블 별도 구현 필요)
    status   varchar(1)      not null, -- 배너 상태 (A 활성화, C 중지, E 종료)

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (쿠폰) 이벤트 배너-사용자 신청 현황 (기획서에는 이벤트 쿠폰이라 되어 있으나, 이벤트 쿠폰에서 쿠폰을 사용하지 않아도 노출되어야 하므로 배너가 맞음)
drop table even_banner_user;
create table even_banner_user
(
    seqno bigint auto_increment
        primary key,
    even_banner_seqno bigint not null, 
    user_seqno bigint not null, 

    used   varchar(1)      not null, -- 사용완료 여부 Y / N (미사용 쿠폰중 기간이 도래하면 기간만료)
    -- 이벤트 쿠폰 사용기간
    real_start_dt        datetime  not null,
    real_end_dt        datetime  not null,
    real_discount_price int null, -- 혜택 금액 (실제 할인된 금액)

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;


-- 관리자 히스토리
drop table admin_action_history;
create table admin_action_history
(
    seqno bigint auto_increment
        primary key,
    admin_seqno bigint not null, 
    admin_id varchar(200) not null,
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    menu varchar(300) not null, -- 무슨 메뉴에서 ?
    action varchar(300) not null, -- 어떤 작업을 했는지 ?
    request_ip varchar(20) not null, -- 어디서
    params text null -- 상세 데이터
) character set utf16;


-- (쿠폰) 쿠폰-사용자 발급 이력
drop table coupon_user_history;
create table coupon_user_history
(
    seqno bigint auto_increment
        primary key,
    coupon_user_seqno bigint not null, 
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    canceled varchar(1) default 'N',
    approved varchar(1) default 'N',
    memo varchar(500) null,
    create_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- (바우처) 바우처-사용자 발급 이력
drop table voucher_user_history;
create table voucher_user_history
(
    seqno bigint auto_increment
        primary key,
    voucher_user_seqno bigint not null, 
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    canceled varchar(1) default 'N',
    approved varchar(1) default 'N',
    memo varchar(500) null,
    create_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- 휴대폰 인증 이력, 번호
create table send_sms_auth_hst
(
    hst_seqno bigint auto_increment
        primary key,
    sender_phone    varchar(100)        null, -- 전송 전화번호
    receive_phone    varchar(100)        null, -- 수신 전화번호
    user_seqno    bigint not null,
    auth_code    varchar(50)      null, -- 인증번호
    create_dt        datetime         default CURRENT_TIMESTAMP null
)character set utf16;

create index send_sms_auth_hst__index_1
    on send_sms_auth_hst (receive_phone, user_seqno);

-- 문자 연동 이력
create table if_send_sms_hst
(
    hst_seqno bigint auto_increment
        primary key,
    sms_id          int(11)        not null, -- 
    callee    varchar(15)        null, -- 
    result_code    varchar(10)        null, -- 
    result    varchar(10)        null, -- 
    success_code    int(11)      null,
    failed_code    int(11)      null,
    send_time    varchar(50)      null, -- 
    create_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

alter table store add column icon varchar(200) default '/user/img/icon_minish_spa.svg';

update store set icon = '/user/img/icon_minish_manul_therapy.svg' where seqno = 6;
update store set icon = '/user/img/icon_foresta_black.svg' where seqno = 5;
update store set icon = '/user/img/icon_deep_focus.svg' where seqno = 4;
update store set icon = '/user/img/icon_minish_spa.svg' where seqno = 2;
update store set icon = '/user/img/icon_valmont_spa.svg' where seqno = 3;
update store set icon = '/user/img/icon_nail.svg' where seqno = 1;

alter table store_service add column orders int default 1;

alter table reservation add column coupon_seqno bigint default 0;
alter table reservation add column discount_price int default 0;

alter table user_info add column memo2    varchar(500);
alter table store add column orders int default 9999;