<?php 

// Imaging
class imaging
{

    // Variables
    private $img_input;
    private $img_output;
    private $img_src;
    private $format;
    private $quality =80;
    private $x_input;
    private $y_input;
    private $x_output;
    private $y_output;
    private $resize;

    // Set image
    public function set_img($img)
    {

        // Find format
        $ext = strtoupper(pathinfo($img, PATHINFO_EXTENSION));

        // JPEG image
        if(is_file($img) && ($ext == "JPG" OR $ext == "JPEG"))
        {

            $this->format = $ext;
            $this->img_input = ImageCreateFromJPEG($img);
            $this->img_src = $img;
            

        }

        // PNG image
        elseif(is_file($img) && $ext == "PNG")
        {

            $this->format = $ext;
            $this->img_input = ImageCreateFromPNG($img);
            $this->img_src = $img;

        }

        // GIF image
        elseif(is_file($img) && $ext == "GIF")
        {

            $this->format = $ext;
            $this->img_input = ImageCreateFromGIF($img);
            $this->img_src = $img;

        }
		
		
        // Get dimensions
        $this->x_input = imagesx($this->img_input);
        $this->y_input = imagesy($this->img_input);

    }

    // Set maximum image size (pixels)
    public function set_size($size = 100)
    {

        // Resize
        if($this->x_input > $size && $this->y_input > $size)
        {

            // Wide
            if($this->x_input >= $this->y_input)
            {

                $this->x_output = $size;
                $this->y_output = ($this->x_output / $this->x_input) * $this->y_input;

            }

            // Tall
            else
            {

                $this->y_output = $size;
                $this->x_output = ($this->y_output / $this->y_input) * $this->x_input;

            }

            // Ready
            $this->resize = TRUE;

        }

        // Don't resize
        else { $this->resize = FALSE; }

    }

    // Set image quality (JPEG only)
    public function set_quality($quality)
    {

        if(is_int($quality))
        {

            $this->quality = $quality;

        }

    }

    // Save image
    public function save_img($path)
    {

        // Resize
        if($this->resize)
        {

            $this->img_output = ImageCreateTrueColor($this->x_output, $this->y_output);
            ImageCopyResampled($this->img_output, $this->img_input, 0, 0, 0, 0, $this->x_output, $this->y_output, $this->x_input, $this->y_input);

        }

        // Save JPEG
        if($this->format == "JPG" OR $this->format == "JPEG")
        {

            if($this->resize) { imageJPEG($this->img_output, $path, $this->quality); }
            else { copy($this->img_src, $path); }

        }

        // Save PNG
        elseif($this->format == "PNG")
        {

            if($this->resize) { imagePNG($this->img_output, $path); }
            else { copy($this->img_src, $path); }

        }

        // Save GIF
        elseif($this->format == "GIF")
        {

            if($this->resize) { imageGIF($this->img_output, $path); }
            else { copy($this->img_src, $path); }

        }
		
		 
    }

    // Get width
    public function get_width()
    {

        return $this->x_input;

    }

    // Get height
    public function get_height()
    {

        return $this->y_input;

    }

    // Clear image cache
    public function clear_cache()
    {

        @ImageDestroy($this->img_input);
        @ImageDestroy($this->img_output);

    }

}

class img_uploader extends imaging{
    
	private $path;
    private $width    = 900;
    
	private $file_name;
	private $file_type;
	private $size;
	
	private $save_path;
	
	
	public function set_path($file){
	  $buff = $file;	  
	 
	  $this->path = $buff['tmp_name'];
	  $this->size = $buff['size'];
	  $this->file_name = $buff['name'];
	  $this->file_type = strrchr($this->file_name,".");	  
	}
	public function set_width($width){
	  $this->width = $width; 
	 // $this->s_width = $s_width;
	}
	public function set_savepath($path){
	
	  // 檢查是否已有此使用者目錄
	  if ( ! is_dir($path)) 
	  // 建立此使用者目錄
	  {
	    mkdir($path,0755); 
	  }
	  
	  $this->save_path = $path;
	}
	public function save(){
	 
     $name =  uniqid().$this->file_type;
		
	 copy($this->path,$this->save_path."/".$name);
    
     $this->set_img($this->save_path."/".$name);
    
     //儲存縮圖
     //$this->set_size($this->s_width);
     //$this->save_img($this->save_path."/s_" . $name);
     //儲存大圖
     $this->set_size($this->width); // 寬度(x)
     $this->save_img($this->save_path."/".$name);

     // Finalize
     $this->clear_cache();
	 //回傳路徑
 	 return $this->save_path."/" . $name;  
	   	
	}
	
	
  }
  
//使用方式
/*

if($_FILES['upload']['type']<> 'image/pjpeg' and $_FILES['upload']['type']<> 'image/jpeg' and $_FILES['upload']['type']<> 'image/gif' and $_FILES['upload']['size']>0){
		  ?>
		 <script> 
		 alert("圖檔類型非jpg或gif檔！");
         location.href = "class_manageb.php";	
		 </script>
		 <?php  		
		}
		elseif($_FILES['upload']['size']>1024*200){
		 ?>
		 <script> 
		 alert("圖片大小超過200kb限制！");
         location.href = "class_manageb.php";	
		 </script>
		 <?php  
		}	
		elseif($_FILES['upload']['size']>0 and $_FILES['upload']['size']<=1024*200)
		{
		$img = new img_uploader;
		$img ->set_path($_FILES['upload']); //置入路徑
		$img ->set_width(150,350);          //決定縮圖大小，大圖大小
		$img ->set_savepath("../images/".date("Y-m-d")); //設定儲存路徑
		list($s_pic,$c_pic)=$img ->save();
		
		//縮圖不需要，刪除
		unlink($s_pic);
		}
		elseif($_FILES['upload']['size']==0){
		  $c_pic = "../images/add.jpg"; //預設圖片
		}

*/
?> 