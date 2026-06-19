var script = document.currentScript || Array.prototype.slice.call(document.getElementsByTagName('script')).pop();
if (typeof urlMain === 'undefined') {
    var urlSy = script.getAttribute('data-url');

    window.location = urlSy + '#!/' + window.location.href.substr(urlSy.length, window.location.href.length);
}
$(function () {
    // 1. เช็คว่ามีตัวแปร Flag นี้ในระดับ window หรือยัง
    if (typeof window.isMyDropdownInitialized === 'undefined') {

        // 2. ถ้ายังไม่มี ให้สร้าง Event ครั้งแรกและครั้งเดียว (ใช้ Delegation ที่ document)
        $(document).on('click', '[data-bs-toggle="dropdown"]', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = $(this);
            const $menu = $btn.next('.dropdown-menu');
            const isOpen = $menu.hasClass('show');

            // ปิดอันอื่น
            $('.dropdown-menu.show').not($menu).removeClass('show');

            if (!isOpen) {
                $menu.addClass('show');
                // บังคับการแสดงผล (กันตารางบัง)

            } else {
                $menu.removeClass('show');
            }
        });

        // จอง Event สำหรับปิดเมื่อคลิกข้างนอก
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        // 3. ติดป้ายบอกว่าติดตั้งแล้วนะ
        window.isMyDropdownInitialized = true;
        console.log("Dropdown: ติดตั้งใหม่เรียบร้อย (หน้าแรกที่โหลด)");
    } else {
        // ถ้ามีแล้ว มันจะไม่ทำอะไรเลย
        console.log("Dropdown: ระบบตรวจพบว่าติดตั้งไปแล้ว ข้ามการทำงาน");
    }

    $('.per-page-selector').on('change', function () {
        let selectedValue = $(this).val();
        $('#per_page_input').val(selectedValue);
        $('#per_page_input').closest('form').submit();
    });
});

iframeBox.find(".needs-validation").each(function (index) {
    addEvent(this);
});


