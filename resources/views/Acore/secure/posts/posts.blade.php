
<section class="main-page" style="margin-top: 100px;">
<div class="container">
<div class="row">
	
@foreach ($posts as $row)
<div class="col-md-2"></div>
<div class="col-md-8 ">
    <div class="posts">
        <div class="title">
            <h3><a href="{{ url('posts/'.$row->alias)}}" > {{ $row->title }} </a> </h3>
        </div>
        <div class="info">
            <i class="fa fa-user"></i>  <span> {{ ucwords($row->username) }}  </span>   
            <i class="fa fa-calendar"></i>  <span> {{ date("M j, Y " , strtotime($row->created)) }} </span> 
            <i class="fa fa-comment-o "></i>   <span> <a href="{{ url('posts/'.$row->pageID.'/'.$row->alias)}}#comments" > {{ $row->comments }}  comment(s) </a> </span> 
        </div>
        <div class="note">
        <?php

        $content = explode('<hr>', $row->note);
        if(count($content)>=1)
        {
            echo AppHelper::formatContent($content[0]);
        } else {
            echo AppHelper::formatContent($row->note);
        }
        ?>

             
        </div>

        <div class="readmore">             
            <a href="{{ url('posts/'.$row->alias)}}" class="btn btn-primary  btn-lg btn-round"><i class="now-ui-icons text_align-left"></i> Read More   
            </a>
        </div>                   
      
     </div>                      
 </div>   
 <div class="col-md-2"></div> 
    @endforeach
 </div>  
</div>	
</section>
<style type="text/css">
    .posts { border-bottom: solid 1px #eee; margin-bottom: 20px; padding-bottom: 10px;   }
    .posts .title h3 { margin: 0 0 10px 0; text-align: center; }
    .posts .info { padding: 10px 0 20px 0; font-size: 12px;  text-align: center;}
    .posts .info i{ font-size: 18px; padding: 0 5px 0 15px; text-align: center;}
    .posts .labels { padding: 10px 0; }
    .posts .image { border: solid 1px #ddd; padding: 5px; margin-bottom: 10px; background: #eee; }
    .posts .readmore { text-align: center }
    .comments {}
    .comments .info{ font-size: 13px; font-weight: 700; }   
    .comments .info .avatar{ width: 40px; float: left;margin-right: 5px;  }
    .comments .content { font-size: 12px; border-bottom: solid 1px #eee;  padding: 5px 0 20px 50px;}
    .cloudtags { margin: 0 5px 5px 0; padding: 5px 10px; border: solid 1px #eee; display: block;  }
    ul.widgeul { margin: 0; padding:0; list-style: none; }
    ul.widgeul li{ clear: both; padding-bottom: 10px; border-bottom: solid 1px #eee;  }
    ul.widgeul li .image{ width: 60px; float: left; padding-right: 15px;  }
        

</style>

