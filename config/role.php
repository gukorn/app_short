<?php

return [
    'goodsissue' => [
        'topic' => 'ข้อมูลการขอเบิกสินค้า',
        'module' => [
            [
                'name' => '3.1 จัดการการขอเบิกสินค้า',
                'function' => [
                    'goodsissue_aoeod' => 'สร้าง/แก้ไข/ลบ',
                ]
            ],
        ],
    ],
    'warehouseleader' => [
        'topic' => 'ข้อมูลหัวหน้าคลัง',
        'module' => [
            [
                'name' => '1.1 จัดการการขออนุมัติ',
                'function' => [
                    'approval' => 'อนุมัติ/ไม่อนุมัติ',
                ]
            ],
        ],
    ],
    'account' => [
        'topic' => 'ข้อมูลฝ่ายบัญชี',
        'module' => [
            [
                'name' => '1.2 จัดการการขออนุมัติ',
                'function' => [
                    'approval' => 'อนุมัติ/ไม่อนุมัติ',
                ]
            ],
        ],
    ],
    'mainwarehouse' => [
        'topic' => 'ข้อมูลคลังหลัก',
        'module' => [
            [
                'name' => '2.1 จัดการรับสินค้าเข้า',
                'function' => [
                    'mwh_aoe' => 'สร้าง/แก้ไข',
                    'mwh_del' => 'ลบ',
                    'mwh_check' => 'ตรวจสอบ',
                    'mwh_import' => 'สินค้านำเข้าจุดวาง',

                ]
            ],
            [
                'name' => '2.2 จัดการติดบาร์โค้ดสินค้า',
                'function' => [
                    'gen_barcode' => 'สร้างบาร์โค้ด/พิมพ์บาร์โค้ด',
                ]
            ],
            [
                'name' => '2.4 จัดการนำเข้าจุดวาง',
                'function' => [
                    'import_stock' => 'รับสินค้าและจัดวาง',
                ]
            ],
            [
                'name' => '2.5 คืนสินค้าให้กับผู้จำหน่าย',
                'function' => [
                    'return_aoe' => 'สร้าง/แก้ไข',
                    'return_del' => 'ลบ',
                    'return_check' => 'ตรวจสอบ',
                ]
            ],

            [
                'name' => '3.3,3.4 จัดการการเบิกออก',
                'function' => [
                    'prepare_pick' => 'หยิบสินค้า',
                    'prepare_pickcheck' => 'ตรวจสอบสินค้า',
                    'prepare_package' => 'แพ็คสินค้า',
                    'prepare_delivery' => 'จัดส่งสินค้า',
                ]
            ],
            [
                'name' => '4.1,4.2 จัดการการขอยืม-คืนสินค้า จากคลังย่อย',
                'function' => [
                    'gi_borrow' => 'จัดการการยืมสินค้า',
                    'gi_return' => 'จัดการการคืนสินค้า',

                ]
            ],
            [
                'name' => '7.1,7.2,7.3,7.4,7.5 จัดการสินค้าในคลัง',
                'function' => [
                    'manage_tracking' => 'ค้นหาสินค้าติดตาม',
                    //'manage_item' => 'สินค้าในคลัง',
                    'manage_move' => 'ย้ายจุดวางสินค้า',
                    'manage_count' => 'ตรวจนับสินค้า',
                    'manage_cycle' => 'ตั้งรอบการนับสินค้า',
                    'manage_adjustment' => 'การปรับปรุงสินค้า',
                    'manage_purchase_requisition' => 'ใบขอซื้อ',
                ]
            ],
        ],
    ],
    'subwarehouse' => [
        'topic' => 'ข้อมูลคลังย่อย',
        'module' => [
            [
                'name' => '2.7 จัดการรับสินค้าเข้า',
                'function' => [
                    'wh_import' => 'รับสินค้าและจัดวาง',
                ]
            ],
            [
                'name' => '3.2 จัดการการเบิกสินค้ากับคลังหลัก',
                'function' => [
                    'goodsissue_aoeod' => 'สร้าง/แก้ไข/ลบ',

                ]
            ],
            [
                'name' => '5.1 จัดการจ่ายสินค้าออก',
                'function' => [
                    'export_item' => 'จ่ายสินค้าออก',
                ]
            ],
            [
                'name' => '6.2,6.3 จัดการจ่ายสินค้ากลับคลังหลัก',
                'function' => [
                    'export_pick' => 'หยิบสินค้า',
                    'export_pickcheck' => 'ตรวจสอบสินค้า',
                    'export_package' => 'แพ็คสินค้า',
                    'export_delivery' => 'จัดส่งสินค้า',
                ]
            ],
            [
                'name' => '6.1 จัดการการคืนสินค้า(กลับคลังหลัก)',
                'function' => [
                    'return_item' => 'จัดการคืนสินค้า',
                ]
            ],

        ],
    ],
    'report' => [
        'topic' => 'รายงาน',
        'module' => [
            [
                'name' => '',
                'function' => [
                    'inventory' => '8.1 รายงานยอดคงเหลือสินค้าคงคลัง',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'goodsreceipt' => '8.2 รายงานการรับเข้า',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'borrowreturn' => '8.3 รายงานการยืม-คืนสินค้า',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'adjustment' => '8.4 รายงานการปรับปรุงสินค้า',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'goodsissue' => '8.5 รายงานเบิกสินค้าจากคลังหลัก',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'goodsissue_expose' => '8.6 รายงานเบิกจ่ายสินค้า',
                ]
            ],

            [
                'name' => '',
                'function' => [
                    'borrow' => '8.7 รายงานขอยืมสินค้า',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'return_item' => '8.8 รายการคืนสินค้า',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'exp_item' => '8.9 รายงานสินค้าใกล้หมดอายุ',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'inv_acc' => '8.10 รายงานยอดคงเหลือสินค้าคงคลัง(บัญชี)',
                ]
            ],
            [
                'name' => '',
                'function' => [
                    'inv_acc2' => '8.11 รายงานยอดคงเหลือสินค้าคงคลังทั้งหมด(บัญชี)',
                ]
            ],

        ],
    ],
    'setting' => [
        'topic' => '9 ตั้งค่าระบบ',
        'module' => [
            [
                'name' => '9.5.1 จัดการผู้ใช้งาน',
                'function' => [
                    'user_add' => 'เพิ่ม',
                    'user_edit' => 'แก้ไข',
                    'user_del' => 'ลบทิ้ง',
                ]
            ],
            [
                'name' => '9.5.2 จัดการสิทธิ์ผู้ใช้งาน',
                'function' => [
                    'role_add' => 'เพิ่ม',
                    'role_edit' => 'แก้ไข',
                    'role_del' => 'ลบทิ้ง',
                ]
            ],
            [
                'name' => '9.1.1 จัดการสินค้า',
                'function' => [
                    'item_aoeod' => 'สร้าง/แก้ไข/ลบ',
                ]
            ],
            [
                'name' => '9.1.2 จัดการหมวดสินค้า',
                'function' => [
                    'itemGroup_aoeod' => 'สร้าง/แก้ไข/ลบ',
                ]
            ],
            [
                'name' => '9.2.1 จัดการคลังสินค้า',
                'function' => [
                    'wh_aoeod' => 'สร้าง/แก้ไข/ลบ',
                ]
            ],
            [
                'name' => '9.2.2 จัดการประเภทโซน',
                'function' => [
                    'zoneType_aoeod' => 'สร้าง/แก้ไข/ลบ',
                ]
            ],
            [
                'name' => '9.2.3 จัดการจุดวางและชั้นวาง',
                'function' => [
                    'zone_aoe' => 'สร้าง/แก้ไข',
                    'zone_del' => 'ลบ',
                ]
            ],
            [
                'name' => '9.3 จัดการภาชนะขนย้าย',
                'function' => [
                    'container_aoe' => 'สร้าง/แก้ไข',
                    'container_del' => 'ลบ',
                ]
            ],
            // [
            //     'name' => '9.4 จัดการพาหนะขนย้าย',
            //     'function' => [
            //         'vehicle_aoe' => 'สร้าง/แก้ไข',
            //         'vehicle_del' => 'ลบ',
            //     ]
            // ],
            [
                'name' => '9.5 จัดการบริษัทจำหน่ายสินค้า',
                'function' => [
                    'vendor_aoe' => 'สร้าง/แก้ไข',
                    'vendor_del' => 'ลบ',
                ]
            ],
            [
                'name' => 'จัดการปรับยอด',
                'function' => [
                    'c_remain' => 'ปรับยอด',
                ]
            ],
            [
                'name' => 'จัดการเปลี่ยนคลัง',
                'function' => [
                    'ch_wh' => 'เปลี่ยนคลัง',
                ]
            ],
        ],
    ],


];
