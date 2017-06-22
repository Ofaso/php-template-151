<!Doctype>
<html>
<head>
	<link rel="stylesheet" href="/Design/design.css">
 	<title>Homepage</title>
</head>
<body>
	<h1>PHP-Template-151 - Blog</h1>
	<?php
		if(!isset($_SESSION['user_id']))
		{
			echo "<form id='login' method='post'>
						<input type='hidden' name='login' id='login'></input>
					   	<Button type='submit'>Login</Button>
				   </form>";
		}
		else
		{
			echo "<form id='logout' method='post'>
						<input type='hidden' name='logout' id='logout' value=".$_SESSION['user_id']."></input>
					   	<Button type='submit'>Logout</Button>
				   </form>";
		}
		if(!isset($_SESSION['user_id']))
		{
			echo "<form id='register' method='post'>
					<input type='hidden' name='register' id='register'></input>
					<Button type='submit'>Register</Button>
      			  </form>";
		}
		if(isset($_SESSION['user_id']))
		{
			echo "<a href='newPost'>New Post</a>";
		}
	echo "<table border='1'>";
	echo "<tr><th>Title</th> <th>Content</th> <th></th> <th>Likes</th> <th>Dislikes</th></tr>";
	if($posts != NULL)
	{
		foreach ($posts as $row)
		{
			echo "<tr>";
			echo "<td>" ?><?=htmlspecialchars($row['title'])?><?php "</td>";
			echo "<td>" ?><?=htmlspecialchars($row['content'])?><?php "</td>";
			echo "<td>" . "<form id='like' method='post'>
					   	<input type='hidden' name='like' id='like' value=".$row['id']."></input>
					   	<Button type='submit'>Like</Button>
					  </form>
					  <form id='dislike' method='post'>
						<input type='hidden' name='dislike' id='dislike' value=".$row['id']."></input>
						<Button type='submit'>Dislike</Button>
					  </form>"  . "</td>";
			echo "<td>".$row['likeCount']."</td>";
			echo "<td>".$row['dislikeCount']."</td>";
			if (isset($_SESSION['user_id'] ))
			{
				if ($_SESSION['user_id'] == $row['user_id'])
				{
					echo "<td><form id='deletePost' method='post'>
						   		<input type='hidden' name='deletePost' id='deletePost' value=".$row['id']."></input>
						   	<Button type='submit'>Delete</Button>
						  </form></td>";
				}
			}
			echo "</tr>";
		}
	}
	echo "</table>";
	?>
</body>
</html>
