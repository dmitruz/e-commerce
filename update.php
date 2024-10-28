<?php


if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
  # Connect to the database.
  require ('connect_db.php'); 

   $errors = array();

# Check for a item name.
  if ( empty( $_POST[ 'id' ] ) )
  { $errors[] = 'Update item ID.' ; }
  else
  { $id = mysqli_real_escape_string( $link, trim( $_POST[ 'id' ] ) ) ; }
  
  # Check for a item name.
  if ( empty( $_POST[ 'product_name' ] ) )
  { $errors[] = 'Update product name.' ; }
  else
  { $n = mysqli_real_escape_string( $link, trim( $_POST[ 'product_name' ] ) ) ; }

  # Check for a item description.
  if (empty( $_POST[ 'description' ] ) )
  { $errors[] = 'Update item description.' ; }
  else
  { $d = mysqli_real_escape_string( $link, trim( $_POST[ 'description' ] ) ) ; }

# Check for a item price.
  if (empty( $_POST[ 'img' ] ) )
  { $errors[] = 'Update image address.' ; }
  else
  { $img = mysqli_real_escape_string( $link, trim( $_POST[ 'img' ] ) ) ; }
  
  # Check for a item price.
  if (empty( $_POST[ 'price' ] ) )
  { $errors[] = 'Update item price.' ; }
  else
  { $p = mysqli_real_escape_string( $link, trim( $_POST[ 'price' ] ) ) ; }

  if ( empty( $errors ) ) 
  {
    $q = "UPDATE products SET id='$id',product_name='$n', desc='$d', image_path='$img', price='$p'  WHERE id='$id'";
    $r = @mysqli_query ( $link, $q ) ;
    if ($r)
    {
       header("Location: read.php");
    } else {
        echo "Error updating record: " . $link->error;
    }
       mysqli_close( $link );
  } 
}
?>
<form action="update.php" method="post" enctype="multipart/form-data">
  <!-- input box for item name  -->
  <label for="name">Product Name:</label>
  <input type="text" id="product_name" class="form-control" name="product_name" required value="<?php echo $current_product_name; ?>">

  <!-- input box for item description -->  
  <label for="description">Description:</label>
  <textarea id="description" class="form-control" name="description" required><?php echo $current_description; ?></textarea>

  <!-- file upload for image -->
  <label for="image">Image:</label>
  <input type="file" id="image_path" class="form-control" name="image_path">

  <!-- input box for item price -->
  <label for="price">Price:</label>
  <input type="number" id="price" class="form-control" name="price" min="0" step="0.01" required value="<?php echo $current_price; ?>"><br>

  <!-- submit button -->
  <input type="submit" class="btn btn-dark" value="Update">
</form>