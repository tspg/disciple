<?php

//------------------------------------------------------------------------------------------------------------+
//
// PHP Huffman Encoder/Decoder for Skulltag (by whoisrich)
//
// Version 1 (September 2009)
// Compatible with Skulltag launchers and servers.
//
//------------------------------------------------------------------------------------------------------------+
//  REFERENCE:
//  http://skulltag.com/wiki/Launcher_protocol
//  http://en.wikipedia.org/wiki/Huffman_coding
//  http://www.greycube.com/help/lgsl_other/skulltag_huffman.txt


  class huffman
  {
    public static $huffman_tree  = array();
    public static $huffman_table = array();

    // STATIC FREQUENCY TABLE WHERE THE INDEX ( 0 - 255 ) IS THE ASCII NUMBER
    public static $huffman_frq = array(
    0.14473691, 0.01147017, 0.00167522, 0.03831121, 0.00356579, 0.03811315, 0.00178254, 0.00199644, 0.00183511,
    0.00225716, 0.00211240, 0.00308829, 0.00172852, 0.00186608, 0.00215921, 0.00168891, 0.00168603, 0.00218586,
    0.00284414, 0.00161833, 0.00196043, 0.00151029, 0.00173932, 0.00218370, 0.00934121, 0.00220530, 0.00381211,
    0.00185456, 0.00194675, 0.00161977, 0.00186680, 0.00182071, 0.06421956, 0.00537786, 0.00514019, 0.00487155,
    0.00493925, 0.00503143, 0.00514019, 0.00453520, 0.00454241, 0.00485642, 0.00422407, 0.00593387, 0.00458130,
    0.00343687, 0.00342823, 0.00531592, 0.00324890, 0.00333388, 0.00308613, 0.00293776, 0.00258918, 0.00259278,
    0.00377105, 0.00267488, 0.00227516, 0.00415997, 0.00248763, 0.00301555, 0.00220962, 0.00206990, 0.00270369,
    0.00231694, 0.00273826, 0.00450928, 0.00384380, 0.00504728, 0.00221251, 0.00376961, 0.00232990, 0.00312574,
    0.00291688, 0.00280236, 0.00252436, 0.00229461, 0.00294353, 0.00241201, 0.00366590, 0.00199860, 0.00257838,
    0.00225860, 0.00260646, 0.00187256, 0.00266552, 0.00242641, 0.00219450, 0.00192082, 0.00182071, 0.02185930,
    0.00157439, 0.00164353, 0.00161401, 0.00187544, 0.00186248, 0.03338637, 0.00186968, 0.00172132, 0.00148509,
    0.00177749, 0.00144620, 0.00192442, 0.00169683, 0.00209439, 0.00209439, 0.00259062, 0.00194531, 0.00182359,
    0.00159096, 0.00145196, 0.00128199, 0.00158376, 0.00171412, 0.00243433, 0.00345704, 0.00156359, 0.00145700,
    0.00157007, 0.00232342, 0.00154198, 0.00140730, 0.00288807, 0.00152830, 0.00151246, 0.00250203, 0.00224420,
    0.00161761, 0.00714383, 0.08188576, 0.00802537, 0.00119484, 0.00123805, 0.05632671, 0.00305156, 0.00105584,
    0.00105368, 0.00099246, 0.00090459, 0.00109473, 0.00115379, 0.00261223, 0.00105656, 0.00124381, 0.00100326,
    0.00127550, 0.00089739, 0.00162481, 0.00100830, 0.00097229, 0.00078864, 0.00107240, 0.00084409, 0.00265760,
    0.00116891, 0.00073102, 0.00075695, 0.00093916, 0.00106880, 0.00086786, 0.00185600, 0.00608367, 0.00133600,
    0.00075695, 0.00122077, 0.00566955, 0.00108249, 0.00259638, 0.00077063, 0.00166586, 0.00090387, 0.00087074,
    0.00084914, 0.00130935, 0.00162409, 0.00085922, 0.00093340, 0.00093844, 0.00087722, 0.00108249, 0.00098598,
    0.00095933, 0.00427593, 0.00496661, 0.00102775, 0.00159312, 0.00118404, 0.00114947, 0.00104936, 0.00154342,
    0.00140082, 0.00115883, 0.00110769, 0.00161112, 0.00169107, 0.00107816, 0.00142747, 0.00279804, 0.00085922,
    0.00116315, 0.00119484, 0.00128559, 0.00146204, 0.00130215, 0.00101551, 0.00091756, 0.00161184, 0.00236375,
    0.00131872, 0.00214120, 0.00088875, 0.00138570, 0.00211960, 0.00094060, 0.00088083, 0.00094564, 0.00090243,
    0.00106160, 0.00088659, 0.00114514, 0.00095861, 0.00108753, 0.00124165, 0.00427016, 0.00159384, 0.00170547,
    0.00104431, 0.00091395, 0.00095789, 0.00134681, 0.00095213, 0.00105944, 0.00094132, 0.00141883, 0.00102127,
    0.00101911, 0.00082105, 0.00158448, 0.00102631, 0.00087938, 0.00139290, 0.00114658, 0.00095501, 0.00161329,
    0.00126542, 0.00113218, 0.00123661, 0.00101695, 0.00112930, 0.00317976, 0.00085346, 0.00101190, 0.00189849,
    0.00105728, 0.00186824, 0.00092908, 0.00160896);



    public static function build_binary_tree()
    {
      // CHECK IF TREE HAS ALREADY BEEN BUILT
      if (self::$huffman_tree) { return; }

      // CREATE STARTING LEAVES
      for ($i=0; $i<256; $i++)
      {
        self::$huffman_tree[] = array("frq"=>self::$huffman_frq[$i], "asc"=>$i);
      }

      // PAIR LEAVES AND BRANCHES BASED ON FREQUENCY UNTIL THERE IS A SINGLE 'ROOT'
      for($i=0; $i<255; $i++)
      {
        $lowest_key1 = -1;
        $lowest_key2 = -1;
        $lowest_frq1 = 1E30;
        $lowest_frq2 = 1E30;

        // FIND THE LOWEST TWO FREQUENCIES
        for($j=0; $j<256; $j++)
        {
          if (self::$huffman_tree[$j] === FALSE) { continue; }

          if (self::$huffman_tree[$j]['frq'] < $lowest_frq1)
          {
            $lowest_key2 = $lowest_key1;
            $lowest_frq2 = $lowest_frq1;
            $lowest_key1 = $j;
            $lowest_frq1 = self::$huffman_tree[$j]['frq'];
          }
          elseif (self::$huffman_tree[$j]['frq'] < $lowest_frq2)
          {
            $lowest_key2 = $j;
            $lowest_frq2 = self::$huffman_tree[$j]['frq'];
          }
        }

        // JOIN THE TWO TOGETHER UNDER A NEW BRANCH
        self::$huffman_tree[$lowest_key1] = array("frq"=>($lowest_frq1 + $lowest_frq2), "branch0"=>self::$huffman_tree[$lowest_key2], "branch1"=>self::$huffman_tree[$lowest_key1]);
        self::$huffman_tree[$lowest_key2] = FALSE;
      }

      // MAKE THE ROOT THE ARRAY
      self::$huffman_tree = self::$huffman_tree[$lowest_key1];
    }



    public static function binary_tree_to_lookup_table($branch, $binary_path = "")
    {
      // CHECK IF TABLE HAS ALREADY BEEN BUILT
      if ($binary_path == "" && self::$huffman_table) { return; }

      // GO THROUGH BRANCHES FINDING LEAVES WHILE TRACKING THE BINARY PATH TAKEN
      if (isset($branch['branch0']))
      {
        self::binary_tree_to_lookup_table($branch['branch0'], $binary_path."0");
        self::binary_tree_to_lookup_table($branch['branch1'], $binary_path."1");
        return;
      }

      self::$huffman_table[$branch['asc']] = $binary_path;
    }



    public static function encode($data_string)
    {
      self::build_binary_tree();
      self::binary_tree_to_lookup_table(self::$huffman_tree);

      // MATCH ASCII TO ENTRIES IN LOOKUP TABLE
      for($i=0; $i<strlen($data_string); $i++)
      {
        $ascii          = ord($data_string[$i]);
        $binary_path    = self::$huffman_table[$ascii];
        $binary_string .= $binary_path;
      }

      // IN THE FIRST BYTE STORE THE NUMBER OF PADDING BITS
      $padding_value = 8 - (strlen($binary_string) % 8);
      $padding_value = strrev(sprintf("%08b", $padding_value));
      $binary_string = $padding_value.$binary_string;

      // CONVERT BINARY STRING INTO ASCII
      for ($i=0; $i<strlen($binary_string); $i=$i+8)
      {
        $binary = substr($binary_string, $i, 8);
        $binary = base_convert(strrev($binary), 2, 10);
        $binary = chr($binary);

        $encoded_string .= $binary;
      }

      return $encoded_string;
    }



    public static function decode($data_string)
    {
      self::build_binary_tree();
      self::binary_tree_to_lookup_table(self::$huffman_tree);

      // GET AND REMOVE THE NUMBER OF PADDING BITS STORED IN THE FIRST BYTE
      $padding_length = ord($data_string[0]);
      $data_string    = substr($data_string, 1);

      // CONVERT ASCII STRING INTO BINARY STRING
      for($i=0; $i<strlen($data_string); $i++)
      {
        $binary_string .= strrev(sprintf("%08b", ord($data_string[$i])));
      }

      // REMOVE PADDING BITS FROM THE END
      $binary_string = substr($binary_string, 0, -$padding_length);

      // MATCH BINARY TO ENTRIES IN LOOKUP TABLE
      while ($binary_string)
      {
        foreach (self::$huffman_table as $ascii => $binary_path)
        {
          $binary_length = strlen($binary_path);

          // NEEDS === OTHERWISE DOES NUMERIC COMPARISON ( 0011 == 11 )
          if (substr($binary_string, 0, $binary_length) === $binary_path)
          {
            $decoded_string .= chr($ascii);
            $binary_string   = substr($binary_string, $binary_length);

            continue 2;
          }
        }

        break; // NO MATCHES FOUND
      }

      return $decoded_string;
    }


  }


//------------------------------------------------------------------------------------------------------------+
// EXAMPLE USAGE:

  define("SQF_NAME",              0x00000001);
  define("SQF_URL",               0x00000002);
  define("SQF_EMAIL",             0x00000004);
  define("SQF_MAPNAME",           0x00000008);
  define("SQF_MAXCLIENTS",        0x00000010);
  define("SQF_MAXPLAYERS",        0x00000020);
  define("SQF_PWADS",             0x00000040);
  define("SQF_GAMETYPE",          0x00000080);
  define("SQF_GAMENAME",          0x00000100);
  define("SQF_IWAD",              0x00000200);
  define("SQF_FORCEPASSWORD",     0x00000400);
  define("SQF_FORCEJOINPASSWORD", 0x00000800);
  define("SQF_GAMESKILL",         0x00001000);
  define("SQF_BOTSKILL",          0x00002000);
  define("SQF_DMFLAGS",           0x00004000);
  define("SQF_LIMITS",            0x00010000);
  define("SQF_TEAMDAMAGE",        0x00020000);
  define("SQF_TEAMSCORES",        0x00040000); // DEPRECIATED
  define("SQF_NUMPLAYERS",        0x00080000);
  define("SQF_PLAYERDATA",        0x00100000);
  define("SQF_TEAMINFO_NUMBER",   0x00200000);
  define("SQF_TEAMINFO_NAME",     0x00400000);
  define("SQF_TEAMINFO_COLOR",    0x00800000);
  define("SQF_TEAMINFO_SCORE",    0x01000000);
  define("SQF_TESTING_SERVER",    0x02000000);
  define("SQF_DATA_MD5SUM",       0x04000000);

  $request_flag = (SQF_NAME|SQF_URL|SQF_EMAIL|SQF_MAPNAME|SQF_MAXCLIENTS|SQF_MAXPLAYERS|SQF_PWADS|SQF_GAMETYPE|SQF_GAMENAME|SQF_IWAD|SQF_FORCEPASSWORD|SQF_FORCEJOINPASSWORD|SQF_GAMESKILL|SQF_BOTSKILL|SQF_DMFLAGS|SQF_LIMITS|SQF_TEAMDAMAGE|SQF_TEAMSCORES|SQF_NUMPLAYERS|SQF_PLAYERDATA|SQF_TEAMINFO_NUMBER|SQF_TEAMINFO_NAME|SQF_TEAMINFO_COLOR|SQF_TEAMINFO_SCORE|SQF_TESTING_SERVER|SQF_DATA_MD5SUM);
  $request_flag = (SQF_NAME|SQF_URL|SQF_EMAIL|SQF_MAPNAME|SQF_MAXCLIENTS|SQF_MAXPLAYERS|SQF_PWADS|SQF_GAMETYPE|SQF_GAMENAME|SQF_IWAD|SQF_FORCEPASSWORD|SQF_FORCEJOINPASSWORD|SQF_GAMESKILL|SQF_BOTSKILL|SQF_DMFLAGS|SQF_LIMITS|SQF_TEAMDAMAGE|               SQF_NUMPLAYERS|SQF_PLAYERDATA|SQF_TEAMINFO_NUMBER|SQF_TEAMINFO_NAME|SQF_TEAMINFO_COLOR|SQF_TEAMINFO_SCORE                                   );

  $request  = pack("l", 199);
  $request .= pack("l", $request_flag);
  $request .= "\x21\x21\x21\x21"; // pack("l", time());

  $request = huffman::encode($request);
  $request = huffman::decode($request);


//------------------------------------------------------------------------------------------------------------+
// EXAMPLE HOW TO SEPARATELY GENERATE AND OUTPUT THE TABLE:

  huffman::build_binary_tree();
  huffman::binary_tree_to_lookup_table(huffman::$huffman_tree);

  $huffman_table = huffman::$huffman_table;
  ksort($huffman_table, SORT_NUMERIC);

  foreach($huffman_table as $ascii => $binary_path)
  {
    echo "{$ascii} -- ".htmlentities(chr($ascii), ENT_QUOTES)." -- {$binary_path} <br />\r\n";
  }

//------------------------------------------------------------------------------------------------------------+

?>