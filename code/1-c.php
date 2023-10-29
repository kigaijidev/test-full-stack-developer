<?php
$html = '<ul>
    <li class="item">
        <div class="image">
            <img src="https://webikevn-8743.kxcdn.com/static/wvn.05eb0c5430506f3.55707512.jpg" alt="EXCITER 135 57ZZ">
        </div>
        <div class="bike-name">
            <a href="https://www.webike.vn/cho-xe-may/bike-detail/exciter-135-57-175-cc-1194114.html">
                Yamaha Exciter 2012 100 - 175 cc
            </a>
        </div>
        <div class="price">
            18.800.000 VNĐ
        </div>
        <div class="seller-info">
            <div class="name">Nguyễn Văn A . <span class="tel">090.000.0000</span></div>
        </div>
        <div class="bike-info">
            <table>
                <tbody>
                    <tr>
                        <td width="18%">
                            <label title="model">Dòng xe</label>
                        </td>
                        <td width="30%">
                            YAMAHA Yamaha Exciter 150 Camo
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label title="year">Đời xe</label>
                        </td>
                        <td>
                            2012
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label title="displacement">Phân khối</label>
                        </td>
                        <td>
                            150cc
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </li>
</ul>';

// Load HTML
$doc = new DOMDocument();
$doc->loadHTML($html);

// Tạo một mảng để lưu trữ thông tin
$data = array();

// Lấy thông tin hình ảnh
$imageTag = $doc->getElementsByTagName('img')->item(0);
$data['image'] = $imageTag->getAttribute('src');

// Lấy đường dẫn href
$aTag = $doc->getElementsByTagName('a')->item(0);
$data['href'] = $aTag->getAttribute('href');

// Lấy tên xe
$data['bike_name'] = trim($aTag->nodeValue);

// Lấy giá
$priceDiv = $doc->getElementsByTagName('div')->item(2);
$data['price'] = preg_replace('/\D/', '', $priceDiv->nodeValue);

// Lấy tên người bán và số điện thoại
$sellerDiv = $doc->getElementsByTagName('div')->item(3);
$sellerName = $sellerDiv->getElementsByTagName('div')->item(0);
$data['seller_name'] = trim(explode('.', $sellerName->nodeValue)[0]);
$telSpan = $sellerDiv->getElementsByTagName('span')->item(0);
$data['tel'] = preg_replace('/\D/', '', $telSpan->nodeValue);

// Lấy model, năm và phân khối
$infoTable = $doc->getElementsByTagName('table')->item(0)->getElementsByTagName('tr');
foreach ($infoTable as $row) {
    $label = $row->getElementsByTagName('label')->item(0);
    $value = $row->getElementsByTagName('td')->item(1);
    $labelTitle = $label->getAttribute('title');
    $data[$labelTitle] = trim($value->nodeValue);
}

// In ra mảng dữ liệu
print_r($data);
?>
