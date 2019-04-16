<?php 
include 'header.php';
if(!$isAdmin){
	header("Location: $root/index.php");
	exit();
}

echo mime_content_type(getcwd() . "/images/yoga/yoga.jpg");
echo mime_content_type(getcwd() . "/images/..");

$features = Feature::read();

$imgCategory = new Select('category', "Select category");
$directories = IOHelper::getDirectories(getcwd() ."/images");
$imgCategory->setOptions($directories);
$imgCategory->render();

$images = IOHelper::getImages(getcwd()."/images/pilates");
echo "<div id='gallery'>";
foreach($images as $image){
	$url = "$root/images/pilates/$image";
	echo "<img src='$url'></img>";
}
echo "</div>";

$featureForm = new Form('feature-create', 'feature_manage.php', 'POST');
$featureForm->setClassList("mx-auto");
$featureTitle = new Input('title', 'Choose feature title');
$featureDetail = new TextArea('detail', 'Write body of feature:');
$featureImage = new Input('image-url', '', 'hidden');
$featureForm->addFields($featureTitle, $featureDetail, $featureImage);
$featureSubmit = new Button('feature_submit', 'Submit');
$featureForm->addButtons($featureSubmit);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$featureForm->setData();
	$featureForm->validate();
	if(isset($_POST['feature_submit']) && !$featureForm->hasErrors()){
		echo "<h4>Success</h4>";
		var_dump($_POST);
	}
}

$featureForm->render();
?>
<script>

var images = $('#gallery img');
var featureImage = document.querySelector('#image-url');
images.bind('click', function(){
	images.removeClass('selected');
	$(this).toggleClass('selected');
	featureImage.value = this.src;
	console.log(featureImage);
	console.log(this.src);

});

</script>

<?php
include 'footer.php';
