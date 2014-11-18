<?php
/**
 * Description of Edit
 *
 *This file displays the information from the database and makes it possible to complete changes
 *
 * @author Hristiyan
 */
require_once './includes/header.php';
require_once './lib/Cv.php';
$CvObj = new Cv();
$result = $CvObj->View($_GET['cv']);
 // print_r($result);die;
?>
<hr></hr>
<a href="./view.php">Back</a>
<hr></hr>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<form method="POST" action="./update.php?cv=<?php echo $_GET['cv']?>;" >
	<h1>Personal info <hr></hr> </h1>
<!-- Show personal info -->
	<?php foreach($result['personalinfo'] as $k=>$v):?>
			<div class="personalinfo" personal_id="<?php echo $k; ?>">
				First Name <input name="first_name" type="text" value="<?php echo $v['first_name']; ?>"/>	</br>
				last_name <input name="last_name" type="text" value="<?php echo $v['last_name']; ?>"/>	</br>
				personal_address <input name="personal_address" type="text" value="<?php echo $v['personal_address']; ?>"/>	</br>
				phone <input name="phone" type="text" value="<?php echo $v['phone']; ?>"/>	</br>
				birthday <input name="birthday" type="text" value="<?php echo $v['birthday']; ?>"/>	</br>
			</div>
	<?php endforeach;?>
	<h1>Education <hr></hr> </h1>
<!-- Show education info -->
	<?php foreach($result['education'] as $k=>$v):?>
		<?php foreach($v as $key=>$val): ?>
			<div class="education" education_id='<?php echo $key?>'>
			Education type 
				<select name="education_type" > 
					<option <?php if( $val['education_type'] =='school'){ echo "selected=selected"; }?>  type="text" value="school">school</option>
					<option <?php if( $val['education_type'] =='university'){ echo "selected=selected"; }?> type="text" value="university">university</option>
				</select></br>
				education_organization <input name="education_organization" type="text" value="<?php echo $val['education_organization']; ?>"/></br>
				education_specialty <input name="education_specialty" type="text" value="<?php echo $val['education_specialty']; ?>"/></br>
				education_city <input name="education_city" type="text" value="<?php echo $val['education_city']; ?>"/></br>
				education_degree <input name="education_degree" type="text" value="<?php echo $val['education_degree']; ?>"/></br>
				graduation <input name="graduation" type="text" value="<?php echo $val['graduation']; ?>"/></br>
			</div>	
		<?php endforeach;?>
	<?php endforeach;?>
	<h1>Experience <hr></hr></h1>
<!-- Show working experience info -->
	<?php foreach($result['experience'] as $k=>$v):?>
		<?php foreach($v as $key=>$val): ?>
		<div class="experience" experience_id='<?php echo $key?>'>
			Experience type 
			    <select name="experince_type" > 
				 	<option <?php if( $val['experince_type'] =='internship'){ echo "selected=selected"; }?>  type="text" value="internship">internship</option>
					<option <?php if( $val['experince_type'] =='realjob'){ echo "selected=selected"; }?> type="text" value="realjob">realjob</option>
			    </select></br>
				experience_from <input name="experience_from" type="text" value="<?php echo $val['experience_from']; ?>"/></br>
				experience_to <input name="experience_to" type="text" value="<?php echo $val['experience_to']; ?>"/></br>
				eperience_position <input name="experience_position" type="text" value="<?php echo $val['eperience_position']; ?>"/></br>
				experience_organization <input name="experience_organization" type="text" value="<?php echo $val['experience_organization']; ?>"/></br>
				experience_city <input name="experience_city" type="text" value="<?php echo $val['experience_city']; ?>"/></br>
		</div>	
		<?php endforeach;?>
	<?php endforeach;?>
<!-- Show interests info -->
	<h1>Interests <hr></hr> </h1>
		<?php foreach($result['interest'] as $k=>$v):?>
	 		<?php foreach($v as $key=>$val): ?>
	 			<div class="interests" interest_id='<?php echo $key?>'>
	 			interst_name <input name="interest_name" type="text" value="<?php echo $val['interst_name']; ?>"/></br>
	 			</div>
	 		<?php endforeach;?>		
	 	<?php endforeach;?>
<!-- Show skils info -->
	<h1>Skils <hr></hr> </h1>
		<?php foreach($result['skill'] as $k=>$v):?>
 			<?php foreach($v as $key=>$val): ?>
 				<div class="skills" skill_id='<?php echo $key?>'>
		  Skill Type<select name="skill_type" > 
						<option <?php if( $val['skill_type'] =='technical'){ echo "selected=selected"; }?>  type="text" value="technical">technical</option>
						<option <?php if( $val['skill_type'] =='personal'){ echo "selected=selected"; }?> type="text" value="personal">personal</option>
			   		</select></br>
	     skill_name <input name="skill_name" type="text" value="<?php echo $val['skill_name']; ?>"/></br>
 				</div>
 		<?php endforeach;?>		
 	<?php endforeach;?>
	<input type="button" class="save" value='Save'> </input>
</form> 
<script type="text/javascript">
	$(document).ready(function(){
		//Store information on btn Save click
		$('.save').click(function(){
				//Save personal info
				var PersonalInfo =  $('.personalinfo') ;
				ExecuteAjax('Cv',"UpdatePersonalInfo",
						{	
							"person_id" : PersonalInfo.attr('personal_id'),
							"first_name": PersonalInfo.find('input[name=first_name]').val().trim(),
							"last_name": PersonalInfo.find('input[name=last_name]').val().trim(),
							"personal_address": PersonalInfo.find('input[name=personal_address]').val().trim(),
							"phone": PersonalInfo.find('input[name=phone]').val().trim(),
							"birthday": PersonalInfo.find('input[name=birthday]').val().trim(),
						}
				);
				//Save education 
				$('.education').each(function(){
					var _this = $(this);
					ExecuteAjax('Cv',"UpdateEducationInfo",
								{
									"education_id":_this.attr('education_id')	,
									"education_type" : _this.find('select[name=education_type]').val().trim(),
									"education_organization" : _this.find('input[name=education_organization]').val().trim(),
									"education_specialty" : _this.find('input[name=education_specialty]').val().trim(),
									"education_city" : _this.find('input[name=education_city]').val().trim(),
									"education_degree" : _this.find('input[name=education_degree]').val().trim(),
									"graduation" : _this.find('input[name=graduation]').val().trim(),
								}
						);
				})
				//Save experience
				$('.experience').each(function(){
					var _this = $(this);
					ExecuteAjax('Cv',"UpdateExperienceInfo",
								{
									"experience_id":_this.attr('experience_id')	,
									"experince_type" : _this.find('select[name=experince_type]').val().trim(),
									"experience_from" : _this.find('input[name=experience_from]').val().trim(),
									"experience_to" : _this.find('input[name=experience_to]').val().trim(),
									"experience_position" : _this.find('input[name=experience_position]').val().trim(),
									"experience_organization" : _this.find('input[name=experience_organization]').val().trim(),
									"experience_city" : _this.find('input[name=experience_city]').val().trim()
								}
						);
				})
				//Save Interests
				$('.interests').each(function(){
					var _this = $(this);
					ExecuteAjax('Cv',"UpdateInterestInfo",
								{
									"interest_id":_this.attr('interest_id')	,
									"interest_name" : _this.find('input[name=interest_name]').val().trim()
								}
						);
				})
				//Save skils
				$('.skills').each(function(){
					var _this = $(this);
					ExecuteAjax('Cv',"UpdateSkillsInfo",
								{
									"skill_id":_this.attr('skill_id')	,
									"skill_name" : _this.find('input[name=skill_name]').val().trim(),
									"skill_type" : _this.find('select[name=skill_type]').val().trim()
								}
						);
				})
				alert('The CV has succesfully saved!');
		});
	});
	function ExecuteAjax(object,method,Params){
		 $.ajax({
			 	url:"update.php",
			 	type: 'POST',
			 	data : {
			 		"PHPobject" : object,
			 		"PHPaction" : method,
			 		"Params": Params
			 	},
			 	success:function(result){
			    }
			});
	}
</script>
<?php  require_once './includes/footer.php';?>