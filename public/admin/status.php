<div class="flex flex-col w-11/12 overflow-x-auto">

    <table class="table text-center">
        <thead>
            <tr class="text-black text-base text-nowrap md:text-xl">
                <th class="w-14">ใบที่</th>
                <th class="w-2/4">ชื่อผู้ยืม</th>
                <th class="">วันที่ทำรายการ</th>
                <th class="">การอนุมัติ</th>
            </tr>
        </thead>
        
        
        <tbody>
            <tr class="text-base text-nowrap md:text-xl">
                <td class="font-bold">1</td>
                <td>admin</td>
                <td><?= date("d-m-Y") ?></td>
                <td><button class="btn btn-md ">ทำการอนุมัติ</button></td>
            </tr>   
           
        </tbody>
    </table>
</div>