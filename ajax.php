<?php ob_start();
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
 // Auto suggetion
    $html = '';
   if(isset($_POST['equipment_tombo']) && strlen($_POST['equipment_tombo']))
   {
     $equipments = find_equipment_by_tombo($_POST['equipment_tombo']);
     if($equipments){
        foreach ($equipments as $equipment):
           $html .= "<li class=\"list-group-item\">";
           $html .= $equipment['tombo'];
           $html .= "</li>";
         endforeach;
      } else {

        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'Nao encontrado';
        $html .= "</li>";

      }

      echo json_encode($html);
   }
 ?>
 <?php

 // find all equipment
  if(isset($_POST['e_tombo']) && strlen($_POST['e_tombo']))
  {
    $equipment_tombo = remove_junk($db->escape($_POST['e_tombo']));
    if($results = find_all_equipment_info_by_tombo($equipment_tombo)){
        $all_sector = find_all('sectors');
        foreach ($results as $result) {

          $html .= "<tr>";

          $html .= "<td id=\"e_tombo\">".$result['tombo']."</td>";

          $html .= "<input type=\"hidden\" name=\"e_id\" value=\"{$result['id']}\">";

          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"responsible_user\">";
          $html  .= "</td>";

          $html .= "<td>";
          $html .= "<select class=\"form-control\" name=\"sector\">";
                    foreach ($all_sector as $sec):
          $html .=    "<option value=\"{$sec['id']}\">{$sec['name']}</option>";
                    endforeach;
          $html .= "</select>";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"loan_date\" data-date data-date-format=\"yyyy-mm-dd\">";
          $html  .= "</td>";

          $html  .= "<td>";
          $html  .= "<button type=\"submit\" name=\"add_loan\" class=\"btn btn-primary\">Registrar Empréstimo</button>";
          $html  .= "</td>";

          $html  .= "</tr>";

        }
    } else {
        $html ='<tr><td>Este equipamento não foi encontrado.</td></tr>';
    }

    echo json_encode($html);
  }
 ?>