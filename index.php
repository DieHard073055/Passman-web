<?php
class model{
  function get_title(){
    return "Passman";
  }

  function initiating_form(){
    $form_data = array(
      array(
        "Enter Pass Phrase ",
        "text",
        "phrase",
        array(
          "type" => "text",
          "class" => "form-control",
          "name" => "phrase",
          "id" => "phrase"
        ),
      ),
      array(
        "Enter Pin Code ",
        "text",
        "pincode",
        array(
          "type" => "text",
          "class" => "form-control",
          "name" => "pincode",
          "id" => "pincode"
        ),
      ),
    );
    return $form_data;
  }
}
class view{
  function get_html($tag, $text, $info=""){
		return "<$tag $info>\n$text\n</$tag>\n";
	}


	function get_input_box($attributes){
		$info = "";
		foreach ($attributes as $att => $key){
			$info .= $att . "=\"" . $key . "\" ";
		}
		return "<input $info/>\n";
	}


	function get_form_element($title, $type, $name, $value){
				$label = $this->get_html("label", $title, "for=\"$name\"");
				$input = $this->get_input_box($value);

				$form_element = $this->get_html(
					"div",
					$label . $input,
					"class =\"form-group\""
				);
		return $form_element;
	}
	function generate_form($title, $form_data, $error="", $phrase=""){

		$form = $this->get_html("h2", $title);
		foreach ($form_data as $form_element) {
			if($error != ""){
				foreach ($error as $key => $val) {

					if($key == $form_element[2]){
						$form .=$this->get_html("p", $val, "class=\"text-danger\"");
					}
				}
			}

			$form .= $this->get_form_element(
				$form_element[0],
				$form_element[1],
				$form_element[2],
				$form_element[3]
			);
		}
		$form .= $this->get_html("button", "Submit","type=\"submit\" name=\"submit\" class=\"btn btn-default\" id=\"submitbutton\" ");
		$form = $this->get_html("form", $form, "action=\"index.php\" method=\"get\" id=\"passphraseform\"");
		$form = $this->get_html("div", $form, "class=\"container-fluid\"");
		$form = $this->get_html("div", $form, "class=\"row\"");
		$form = $this->get_html("div", $form, "class=\"col-xs-6 col-md-4\"");
		$form = $this->get_html("body", $form, "class = \"container\"");

		echo $form;
  }

  function show_password($title, $phrase){
    $form = $this->get_html("h3", "Password : " . $phrase);
    $form = $this->get_html("div", $form, "class=\"container-fluid\"");
		$form = $this->get_html("div", $form, "class=\"row\"");
    echo $form;
  }

  function print_header($title){
		include 'head.php';
	}
}


class controller{
  function main(){
    $appModel = new model;
    $appView = new view;
    if(!isset($_GET['submit'])){
      $appView->print_header($appModel->get_title());
      $appView->generate_form(
        $appModel->get_title(),
        $appModel->initiating_form()
     );
   }else if(isset($_GET['phrase']) && isset($_GET['pincode'])){
     require './generate_password.php';
     $seed = $_GET['phrase'];
     $num = $_GET['pincode'];
     $passwords = generate_pass(25, $seed, $num);

     $appView->print_header($appModel->get_title());
     $appView->show_password($appModel->get_title(), $passwords[$num-1]);
     $appView->generate_form(
       $appModel->get_title(),
       $appModel->initiating_form()
    );

    }else{
     var_dump($_GET);
   }
  }
}

$controller = new controller;
$controller->main();
