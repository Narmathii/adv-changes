<?php

namespace App\Controllers\admin;

use App\Models\admin\CampSubmenuModel;

class CampSubmenuController extends BaseController
{
    public function campSubmenu()
    {
        $db = \Config\Database::connect();
        $res['menu'] = $db->query('SELECT camp_menu_id , camp_menu  FROM `tbl_camping_menu` WHERE flag = 1 ORDER BY camp_menu ASC')->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/campSubmenu', $res);
        }


    }

    public function insertCampSubmenu()
    {
        $db = \Config\Database::connect();
        $modal = new CampSubmenuModel;

        $MenuId = $this->request->getPost('camp_menu_id');
        $SubMenu = $this->request->getPost('c_submenu');

        $modalImg = $this->request->getFile('csubmenu_img');

        // Validate if the image file is uploaded correctly
        if ($modalImg && $modalImg->isValid() && !$modalImg->hasMoved()) {

            // Check file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Add or remove as needed
            if (!in_array($modalImg->getMimeType(), $allowedTypes)) {
                $result['code'] = 400;
                $result['status'] = 'Invalid File Format';
                $result['msg'] = 'Only JPEG, PNG and GIF files are allowed.';
                echo json_encode($result);
                return; // Exit early
            }

            // Check file size (e.g., limit to 2MB)
            if ($modalImg->getSize() > 2 * 1024 * 1024) { // 2MB in bytes
                $result['code'] = 400;
                $result['status'] = 'File Too Large';
                $result['msg'] = 'File size must be less than 2MB.';
                echo json_encode($result);
                return; // Exit early
            }

            // Move the file
            $modalImg->move('./uploads/modalImg/');
            $file_path = '/uploads/modalImg/';
            $name = $modalImg->getName();

            $data = [
                'camp_menuid' => $MenuId,
                'c_submenu' => $SubMenu,
                'csubmenu_img' => $file_path . $name,
            ];

            $modal->insert($data);
            $affectedRows = $db->affectedRows();

            if ($affectedRows === 1) {
                $result['code'] = 200;
                $result['msg'] = 'Data Inserted Successfully';
                $result['status'] = 'success';
                echo json_encode($result);
            } else {
                $result['code'] = 400;
                $result['status'] = 'Failed';
                $result['msg'] = 'Something went wrong while inserting data.';
                echo json_encode($result);
            }
        } else {
            // Handle the case where the file is not valid
            if ($modalImg->hasMoved()) {
                $result['code'] = 400;
                $result['status'] = 'File Already Moved';
                $result['msg'] = 'File has already been moved. Please try again.';
            } else {
                $result['code'] = 400;
                $result['status'] = 'Invalid File';
                $result['msg'] = $modalImg->getErrorString() . ' (' . $modalImg->getError() . ')'; // More specific error message
            }
            echo json_encode($result);
        }
    }


    public function getCampSubmenu()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT a.camp_menu_id , a.camp_menu ,b.* FROM tbl_camping_menu AS a 
        INNER JOIN tbl_camping_submenu AS b 
        ON a.camp_menu_id = b.camp_menuid 
        WHERE b.flag =  1 ORDER BY `camp_menu` ASC ';
        $res = $db->query($query)->getResultArray();

        echo json_encode($res);
    }

    public function updateCampSubmenu()
    {
        $Submenu = $this->request->getPost();

        $SubmenuId = $this->request->getPost('c_submenu_id');
        $menuId = $this->request->getPost('camp_menu_id');
        $Submenu = $this->request->getPost('c_submenu');

        $db = \Config\Database::connect();
        $modal = new CampSubmenuModel;

        $validation = service('validation');
        $validation->setRules([
            'csubmenu_img' => 'uploaded[csubmenu_img]|mime_in[csubmenu_img,image/png,image/jpg,image/jpeg]',
        ]);


        // getOld accessID ProductList
        $query1 = "SELECT `camp_menuid` ,`c_submenu_id`  FROM `tbl_camping_submenu` WHERE `c_submenu_id`  = ? AND flag = 1";
        $getSubmenu = $db->query($query1, [$SubmenuId])->getResultArray();

        $OldAccID = $getSubmenu[0]['camp_menu_id'];
        $OldSubAccID = $getSubmenu[0]['c_submenu_id'];

        $query2 = "SELECT `prod_id` FROM `tbl_camping_products` WHERE `flag` = 1  AND `c_submenu_id` = ? AND camp_menu_id = ?";
        $getProducts = $db->query($query2, [$OldSubAccID, $OldAccID])->getResultArray();



        $data = [
            'camp_menuid' => $menuId,
            'c_submenu' => $Submenu,
        ];
        if ($this->request->getFile('csubmenu_img') != '') {
            $image_file = $this->request->getFile('csubmenu_img');
            $newImageFile = $image_file->getRandomName();
            $prodname = str_replace(" ", "_", $newImageFile);
            $filepath = '/uploads/modalImg/';

            $image_file->move('./uploads/modalImg/', $newImageFile);

            $data['csubmenu_img'] = $filepath . $prodname;
        }


        $modal->update($SubmenuId, $data);

        $affectedRows = $db->affectedRows();

        if ($affectedRows == 1) {
            for ($i = 0; $i < count($getProducts); $i++) {
                $ProdID = $getProducts[$i]['prod_id'];

                $updateqry = "UPDATE tbl_camping_products SET camp_menu_id = ?  WHERE c_submenu_id = ? AND camp_menu_id = ?";
                $updateProducts = $db->query($updateqry, [$menuId, $OldSubAccID, $OldAccID]);
            }
        }


        if ($affectedRows === 1) {
            $result['code'] = 200;
            $result['msg'] = 'Data updates Successfully';
            $result['status'] = 'success';
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['msg'] = 'Something Wrong';
            $result['status'] = 'failure';
            echo json_encode($result);
        }
    }


    public function deleteCampSubmenu()
    {
        $db = \Config\Database::connect();

        $SubmenuId = $this->request->getPost('c_submenu_id');

        $query = 'UPDATE`tbl_camping_submenu` SET `flag` = 0 WHERE`c_submenu_id` = ?';
        $res = $db->query($query, [$SubmenuId]);

        $affected_rows = $db->affectedRows();

        if ($affected_rows && $res) {
            $result['code'] = 200;
            $result['status'] = 'success';
            $result['message'] = 'Deleted Successfully';
            echo json_encode($result);
        } else {
            $result['code'] = 400;
            $result['status'] = 'Failure';
            $result['message'] = 'Something wrong';
            echo json_encode($result);
        }


    }



}