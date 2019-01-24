<?php

session_start();

function Message(){
	if (isset($_SESSION['ErroMessage'])){
		$outpout ="<div class='alert alert-danger'>";
		$outpout.= htmlentities($_SESSION['ErroMessage']);
		$outpout.='</div>';
		$_SESSION['ErroMessage'] = null;
		return $outpout;
	}
}


function SuccessMessage(){
	if (isset($_SESSION['SuccessMessage'])){
		$outpout ="<div class='alert alert-success'>";
		$outpout.= htmlentities($_SESSION['SuccessMessage']);
		$outpout.='</div>';
		$_SESSION['SuccessMessage'] = null;
		return $outpout;
	}
}
?>
