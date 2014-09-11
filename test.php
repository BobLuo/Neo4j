<html>
<head>

<meta charset="utf-8">
</head>
<body>
<form method='post'>
<input type='text' name='search' value="<?php if(isset($_POST['search'])) echo $_POST['search'];?>"/>
<input type='submit' name='submit' value='submit'/>
</form
<?php
//echo phpinfo();


use Everyman\Neo4j\Client,
	Everyman\Neo4j\Index\NodeIndex,
	Everyman\Neo4j\Relationship,
	Everyman\Neo4j\Node,
	Everyman\Neo4j\Cypher;

require_once 'example_bootstrap.php';


if($_POST)
{
	$client = new Client();
	$queryTemplate	= "match (m:Member{name:'陈林坚'})-[:Link*1..5{name:'friend'}]-(f:Member)-[:Have]-(s:Skill{tag:'".$_POST['search']."'}) return f,s";
	//var_dump($_POST);die;
	//var_dump($queryTemplate);die;
	$query = new Cypher\Query($client, $queryTemplate);
	$result = $query->getResultSet();
	echo "搜索到".count($result)." 条记录在你的朋友圈中：<br/>";
	if(!empty($result))
	{
		foreach($result as $row) {
			echo "  ".$row['f']->getProperty('name')."    ";
			echo "  ".$row['s']->getProperty('tag')."<br/>";
		}
	}
}

?>



</body>
</html>