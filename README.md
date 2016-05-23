# Demo-ci-advance
Phiên bản Ci demo website với custom blade-laravel và CMS Enuy
Sử dụng phiên bản Codeigniter 3.0.6 
Kết hợp Blade-Laravel 
Phiên bản hỗ trợ PHP version>=5.5.9
=> Hỗ trợ code nhanh gọn, không xuất hiện code trong file view, tất cả ở dạng short code, đơn giản dễ chỉnh sửa và nâng cấp.

1 số thẻ tag để thực hiện trong code
<DBS-l.tên-bảng.số-thứ-tự|where:điều-kiên-1 = giá-trị,dk2 = gt2|order:id desc,limit:0,10-->
giá trị id {(item-tên-bảng-số-thứ-tự.id)} Viết liền không cách, không dấu
<DBE-l.tên-bảng.sô-thứ-tự-->

Get setting trong DB: {[KEYWORD]}
Get Lang: {:Từ khóa:}
Viết code php trong thẻ tag: {@@}
1 số function mặc định
{%HEADER%} : In tiêu đề trang
{%BREADCRUMB%}: Breadcrumb của trang
