<div class = "row" >
   <div class="main">

<!--       <form action="http://postcatcher.in/catchers/4f255ebf07c5140100000005" method="post" accept-charset="utf-8"> 
 -->      
      <?php 
        echo form_open('game/join_team');
      ?>
      <input name = "teamid" style = "display: none;" value = "<?php echo $teamid ?>"> </input>
      <input type="submit" value = "Join This Team" id = "player_status" class = "alert-message success"/></form> 

  <div id = "gravatar"> 
    <? echo $profile_pic_url ?> </br>
  </div>
  <div class = "line"> 
    Name: <span class = "profile_data_item"> <? echo $team_name; ?> </span>
  </div>
  <div class = "line"> 
    description: <span class = "profile_data_item"> <? echo $description; ?> </span>
  </div>    


   </div>
   <div class="sidebar">
      <h3>Info</h3>
      <div class = "infoitem">
         <b> Game Play:</b> <br>
         Feb 6th - Feb 12th
      </div>
      <div class = "tinyline"></div>
      <div class = "infoitem">
         <b> Registration Deadline:</b><br>
         Jan 27th
      </div>
      <div class = "tinyline"></div>
      <div class = "infoitem">
         <b> Orientation Dates:</b><br>
         Jan 30th - Feb 3rd 
      </div>
      <div class = "tinyline"></div>
      <div class = "infoitem">
         <b> Contact:</b><br>
         <a href = "mailto:UofIHvZ@gmail.com"> UofIHvZ@gmail.com </a> <br>
         <a href = "http://www.facebook.com/groups/194292097284119/"> Facebook Group </a>
      </div>
      <div class = "tinyline"></div>
      <div class = "infoitem">
         <a href = "http://www.facebook.com/groups/194292097284119/"> Rules </a>
      </div>
   </div>
</div>
