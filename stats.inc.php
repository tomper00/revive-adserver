<?

$i = 0;

?>
<table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td bgcolor=#99999>
<table width="100%" cellpadding=3 cellspacing=1 border=0>
<?
$totaladviews = 0;
$totaladclicks = 0;
$where = "";

while ($row_banners = mysql_fetch_array($res_banners))
      {
      $where .= " bannerID = $row_banners[bannerID] OR";
      $bgcolor="#F7F7F7";
      $i % 2 ? 0: $bgcolor= "#ECECFF";
      $i++;
      ?>
      <tr>
       <td colspan="2" bgcolor="<?echo $bgcolor;?>" width="100%">
       <?
       if ($row_banners["format"] == "html")
         {
         echo htmlspecialchars(stripslashes($row_banners["banner"]));
         }
      else
         {
         echo "<p><img src=\"./viewbanner.php$fncpageid&bannerID=$row_banners[bannerID]\" width=$row_banners[width] height=$row_banners[height]>";
         }
      ?>
       </td>
      </tr>
      <tr>
       <td bgcolor="#eeeeee" width="90%">
       <?
      $res_adviews = mysql_db_query($phpAds_db, "
                 SELECT
                   Count(*) as qnt
                 FROM
                   $phpAds_tbl_adviews
                 WHERE
                   bannerID = $row_banners[bannerID]
                 ") or mysql_die();
      $row_adviews = mysql_fetch_array($res_adviews);                 
      echo "$strViews:";
       ?>
       </td>
       <td bgcolor="<?echo $bgcolor;?>" width="10%"><b>
       <?
       echo $row_adviews["qnt"];
       $totaladviews += $row_adviews["qnt"];
       ?></b>
       </td>
      </tr>
      <tr>
       <td bgcolor="#eeeeee" width="90%">
      <?
      $res_adclicks = mysql_db_query($phpAds_db, "
                 SELECT
                   Count(*) as qnt
                 FROM
                   $phpAds_tbl_adclicks
                 WHERE
                   bannerID = $row_banners[bannerID]
                 ") or mysql_die();
      $row_adclicks = mysql_fetch_array($res_adclicks);
      echo "$strClicks:";
      ?>
       </td>
       <td bgcolor="<?echo $bgcolor;?>" width="10%"><b>
         <?
         echo $row_adclicks["qnt"];
         $totaladclicks += $row_adclicks["qnt"];
         ?></b>
        </td>
      </tr>
      <tr>
       <td bgcolor="#eeeeee" width="90%">
      <?
      echo "$strRatio:";
      ?>
       </td>
       <td bgcolor="<?echo $bgcolor;?>" width="10%"><b>
         <?
         if ($row_adclicks["qnt"] != 0)
            {
            $percent = 100 / ($row_adviews["qnt"]/$row_adclicks["qnt"]);
            printf(" %.2f%%", $percent);
            }
         else
            echo "0%";
         ?></b>
        </td>
      </tr>      
      <tr>
       <td bgcolor="<?echo $bgcolor;?>">
       <?
       if ($row_adclicks["qnt"] > 0 || $row_adviews["qnt"] > 0)
          {
          echo "<a href=\"detailstats.php$fncpageid&bannerID=$row_banners[bannerID]\">$strDetailStats</a>";
          }
       ?>
       </td>
       <td bgcolor="<?echo $bgcolor;?>">
       <?print "<a href=\"resetstats.php$fncpageid&bannerID=$row_banners[bannerID]\">$strResetStats</a>";?>
       </td>
      </tr>
      <?
      }
      ?>
      <tr>
       <td bgcolor="#CCCCCC" width="90%"><?echo $strTotalViews;?>:</td>
       <td bgcolor="#CCCCCC" width="10%"><b><?echo $totaladviews;?></b></td>
      </tr>
      <tr>
       <td bgcolor="#CCCCCC" width="90%"><?echo $strTotalClicks;?>:</td>
       <td bgcolor="#CCCCCC" width="10%"><b><?echo $totaladclicks;?></b></td>
      </tr>
      <?
      if(function_exists("imagegif") && $totaladviews > 0)
      {
      ?>
      <tr>
       <td bgcolor="#CCCCCC" colspan=2 width="90%" align="center"><img  src="sphourly.php?where=<?$where = ereg_replace("OR$", "", $where); echo urlencode("$where");?>" border="0" width="385" height="150"></td>
      </tr>
      <?
      }
      ?>
      </table>
      </td></tr>
      </table>
    
