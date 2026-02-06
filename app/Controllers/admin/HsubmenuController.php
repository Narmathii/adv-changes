<?php

namespace App\Controllers\admin;

use App\Models\admin\HelmetSubmenuModel;

class HsubmenuController extends BaseController
{
    public function subMenu()
    {
        $db = \Config\Database::connect();
        $res['menu'] = $db->query('SELECT `h_menu_id`,`h_menu` FROM `tbl_helmet_menu` WHERE `flag`= 1 ORDER BY h_menu ASC')->getResultArray();

        $session = \Config\Services::session();

        if ($session->get('login_sts') == "") {
            return redirect()->to('admin');
        } else {
            return view('admin/helmetSubmenu', $res);
        }



    }

    public function insertsubMenu()
    {
        $db = \Config\Database::connect();
        $modal = new HelmetSubmenuModel;

        $MenuId = $this->request->getPost('h_menu_id');
        $SubMenu = $this->request->getPost('h_submenu');

        $validation = \Config\Services::validation();
        $validation->setRules([
            'hsubmenu_img' => 'uploaded[hsubmenu_img]|max_size[hsubmenu_img,1024]|is_image[hsubmenu_img]'
        ]);


        if (!$validation->withRequest($this->request)->run()) {
            $res = $validation->getErrors();
            $result['code'] = 400;
            $result['status'] = 'Failed';
            $result['msg'] = $res;
            echo json_encode($result);
        } else {
            $modalImg = $this->request->getFile('hsubmenu_img');
            $modalImg->move('./uploads/modalImg/');
            $file_path = '/uploads/modalImg/';
            $name = $modalImg->getName();

            $data = [
                'h_menu_id' => $MenuId,
                'h_submenu' => $SubMenu,
                'hsubmenu_img' => $file_path . $name,
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
                $result['msg'] = 'Something wrong';
                echo json_encode($result);
            }
        }
    }

    public function getsubMenu()
    {
        $db = \Config\Database::connect();

        $query = 'SELECT a.`h_menu_id`,a.`h_menu` , b.*  FROM `tbl_helmet_menu`AS a INNER JOIN 
        tbl_helmet_submenu  AS b ON a.`h_menu_id` = b.h_menu_id WHERE b.flag =1 ORDER BY h_menu ASC ;';
        $res = $db->query($query)->getResultArray();
        echo json_encode($res);
    }

    public function updatesubMenu()
    {

        $SubmenuId = $this->request->getPost('h_submenu_id');
        $menuId = $this->request->getPost('h_menu_id');
        $Submenu = $this->request->getPost('h_submenu');

        $db = \Config\Database::connect();
        $modal = new HelmetSubmenuModel;

        $validation = service('validation');
        $validation->setRules([
            'hsubmenu_img' => 'uploaded[hsubmenu_img]|mime_in[hsubmenu_img,image/png,image/jpg,image/jpeg]',
        ]);

        // getOld accessID ProductList
        $query1 = "SELECT `h_menu_id` ,`h_submenu_id`  FROM `tbl_helmet_submenu` WHERE `h_submenu_id`  = ? AND flag = 1";
        $getSubmenu = $db->query($query1, [$SubmenuId])->getResultArray();

        $OldAccID = $getSubmenu[0]['h_menu_id'];
        $OldSubAccID = $getSubmenu[0]['h_submenu_id'];

        $query2 = "SELECT `prod_id` FROM `tbl_helmet_products` WHERE `flag` = 1  AND `h_submenu_id` = ? AND h_menu_id = ?";
        $getProducts = $db->query($query2, [$OldSubAccID, $OldAccID])->getResultArray();


        $data = [
            'h_menu_id' => $menuId,
            'h_submenu' => $Submenu,
        ];
        if ($this->request->getFile('hsubmenu_img') != '') {
            $image_file = $this->request->getFile('hsubmenu_img');
            $newImageFile = $image_file->getRandomName();
            $prodname = str_replace(" ", "_", $newImageFile);
            $filepath = '/uploads/modalImg/';

            $image_file->move('./uploads/modalImg/', $newImageFile);

            $data['hsubmenu_img'] = $filepath . $prodname;
        }


        $modal->update($SubmenuId, $data);

        $affectedRows = $db->affectedRows();

        if ($affectedRows == 1) {
            for ($i = 0; $i < count($getProducts); $i++) {
                $ProdID = $getProducts[$i]['prod_id'];

                $updateqry = "UPDATE tbl_helmet_products SET h_menu_id = ?  WHERE h_submenu_id = ? AND h_menu_id = ?";
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


    public function deletesubMenu()
    {
        $db = \Config\Database::connect();

        $SubmenuId = $this->request->getPost('h_submenu_id');

        $query = 'UPDATE`tbl_helmet_submenu` SET `flag` = 0 WHERE`h_submenu_id` = ?';
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