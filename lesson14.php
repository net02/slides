<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=1024, user-scalable=no">
        <title>PHP - Forms, files.. and regular expressions</title>
        <!-- Required stylesheet -->
        <link rel="stylesheet" media="screen" href="core/deck.core.css">
        <!-- Extension CSS files go here. Remove or add as needed. -->
        <link rel="stylesheet" media="screen" href="extensions/goto/deck.goto.css">
        <link rel="stylesheet" media="screen" href="extensions/menu/deck.menu.css">
        <link rel="stylesheet" media="screen" href="extensions/navigation/deck.navigation.css">
        <link rel="stylesheet" media="screen" href="extensions/status/deck.status.css">
        <link rel="stylesheet" media="screen" href="extensions/scale/deck.scale.css">
        <link rel="stylesheet" media="screen" href="extensions/google-code-prettify/prettify.css">
        <!-- Style theme. More available in /themes/style/ or create your own. -->
        <link rel="stylesheet" media="screen" href="themes/style/web-2.0.css">
        <!-- Transition theme. More available in /themes/transition/ or create your own. -->
        <link rel="stylesheet" media="screen" href="themes/transition/horizontal-slide.css">
        <!-- Basic black and white print styles -->
        <link rel="stylesheet" media="print" href="core/print.css">
        <link rel="stylesheet" media="screen" href="themes/overrides.css">
        <!-- Required Modernizr file -->
        <script src="modernizr.custom.js"></script>
    </head>
    <body>
        <div class="deck-container">
            <!-- Begin slides. Just make elements with a class of slide. -->
            <section class="slide">
                <h1>PHP<br/>Forms, files..<br/>and regular expressions<br/><small>Lesson 14</small></h1>
            </section>
            <section class="slide">
                <h2>HTTP Requests</h2>
                <img src="images/lesson14/requests.gif" style="min-width: 70%" />
                <p>
                    Il client (browser) comunica con il web server tramite richieste HTTP
                </p>
            </section>
            <section class=slide>
                <h2>HTTP Requests</h2>
                <pre class="scroll">GET /slides/lesson14.php HTTP/1.1
Host: localhost
Connection: keep-alive
Pragma: no-cache
Cache-Control: no-cache
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97 Safari/537.36
Accept-Encoding: gzip, deflate, sdch
Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4</pre>
            </section>
            <section class="slide">
                <h2>HTTP Requests<br/><small>extracting information</small></h2>
                <p>
                    Esposti dal web server nella variabile <strong>superglobale</strong> <em>$_SERVER</em>
                    <ul>
                        <li>contenuto non garantito</li>
                        <li>standardizzati in <em>CGI/1.1</em></li>
                    </ul>
                </p>
            </section>
            <section class="slide">
                <h2>HTTP Requests<br/><small>$_SERVER</small></h2>
                <div><?php var_dump($_SERVER); ?></div>
            </section>
            <section class="slide">
                <h2>Sending information</h2>
                <p>
                    Oltre all'indirizzo (<strong>Uniform Resource Locator</strong>) posso inviare altri dati
                </p>
                <div class="slide">
                    <ul>
                        <li>coppie chiave / valore</li>
                        <li>specifica codifica (<em>URL encoding</em>)</li>
                    </ul>
                    <pre>name1=value1&name2=value2</pre>
                </div>
            </section>
            <section class="slide">
                <h2>Sending information<br/><small>using GET</small></h2>
                <p>
                    I dati vengono appesi all'indirizzo, separati da un <strong>?</strong>
                    <pre>http://example.com/index.php?name1=value1&name2=value2</pre>
                </p>
                <ul>
                    <li>limitato a 1024 caratteri</li>
                    <li>informazioni esposte</li>
                    <li>accessibile da QUERY_STRING</li>
                    <li>o dalla variabile <em>$_GET</em></li>
                </ul>
            </section>
            <section class="slide">
                <h2>Sending information<br/><small>using GET</small></h2>
                <pre class="xdebug-var-dump" dir="ltr">// var_dump($_SERVER);
<b>array</b> <i>(size=32)</i>
  [...]
  'REQUEST_METHOD' <font color="#888a85">=&gt;</font> <small>string</small> <font color="#cc0000">'GET'</font> <i>(length=3)</i>
  'QUERY_STRING' <font color="#888a85">=&gt;</font> <small>string</small> <font color="#cc0000">'name1=value1&amp;name2=value2'</font> <i>(length=25)</i>
  'REQUEST_URI' <font color="#888a85">=&gt;</font> <small>string</small> <font color="#cc0000">'/slides/lesson14.php?name1=value1&amp;name2=value2'</font> <i>(length=46)</i>
  'SCRIPT_NAME' <font color="#888a85">=&gt;</font> <small>string</small> <font color="#cc0000">'/slides/lesson14.php'</font> <i>(length=20)</i>
  'PHP_SELF' <font color="#888a85">=&gt;</font> <small>string</small> <font color="#cc0000">'/slides/lesson14.php'</font> <i>(length=20)</i>
</pre>
<pre class="xdebug-var-dump" dir="ltr">// var_dump($_GET);
<b>array</b> <i>(size=2)</i>
  'name1' <font color="#888a85">=&gt;</font> <small>string</small> <font color="#cc0000">'value1'</font> <i>(length=6)</i>
  'name2' <font color="#888a85">=&gt;</font> <small>string</small> <font color="#cc0000">'value2'</font> <i>(length=6)</i>
</pre>
            </section>
            <section class="slide">
                <h2>Sending information<br/><small>enter forms</small></h2>
                <p class="slide">I form permettono all'utente di interagire con il web server inviando <em>attivamente</em> informazioni.</p>
                <p class="slide">Parte della popolarità di PHP è dovuta alla semplicità di interazione con i form HTML.</p>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>GET</small></h2>
                <pre class="prettyprint lang-html">&lt;form action=&quot;get.php&quot; method=&quot;GET&quot;&gt;
    &lt;p&gt;Your name: &lt;input type=&quot;text&quot; name=&quot;name&quot; /&gt;&lt;/p&gt;
    &lt;p&gt;Your age: &lt;input type=&quot;text&quot; name=&quot;age&quot; /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;input type=&quot;submit&quot; /&gt;&lt;/p&gt;
&lt;/form&gt;</pre>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>GET</small></h2>
                <form action="examples/lesson14/get.php" method="GET" class="ajax">
                     <p>Your name: <input type="text" name="name" /></p>
                     <p>Your age: <input type="text" name="age" /></p>
                     <p><input type="submit" /></p>
                </form>
                <div class="result hide"></div>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>GET</small></h2>
                <pre class="prettyprint lang-html">&lt;form action=&quot;get.php&quot; method=&quot;GET&quot;&gt;
    &lt;p&gt;Value 1: &lt;input type=&quot;text&quot; name=&quot;values[]&quot; /&gt;&lt;/p&gt;
    &lt;p&gt;Value 2: &lt;input type=&quot;text&quot; name=&quot;values[]&quot; /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;input type=&quot;submit&quot; /&gt;&lt;/p&gt;
&lt;/form&gt;</pre>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>GET</small></h2>
                <form action="examples/lesson14/get.php" method="GET" class="ajax">
                     <p>Value 1: <input type="text" name="values[]" /></p>
                     <p>Value 2: <input type="text" name="values[]" /></p>
                     <p><input type="submit" /></p>
                </form>
                <div class="result hide"></div>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>Sanitize user input!</small></h2>
                <img src="images/lesson14/injection.png" />
                <div class="slide">
                    <p>
                        <strong>htmlspecialchars()</strong> &amp; <strong>filter_var()</strong>
                    </p>
                </div>
            </section>
            <section class="slide">
                <h2>Sending information<br/><small>using POST</small></h2>
                <p>
                    I dati vengono codificati ed appesi come contenuto della richiesta
                    <pre class="scroll">POST /slides/examples/lesson14/post.php HTTP/1.1
Content-Length: 15
Content-Type: application/x-www-form-urlencoded; charset=UTF-8

name1=value1&name2=value2
</pre>
                </p>
                <ul>
                    <li>nessun limite teorico</li>
                    <li>informazioni criptabili (HTTPS)</li>
                    <li>accessibile dalla variabile <em>$_POST</em></li>
                </ul>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>POST</small></h2>
                <pre class="prettyprint lang-html">&lt;form action=&quot;post.php&quot; method=&quot;POST&quot;&gt;
    &lt;p&gt;Your name: &lt;input type=&quot;text&quot; name=&quot;name&quot; /&gt;&lt;/p&gt;
    &lt;p&gt;Your age: &lt;input type=&quot;text&quot; name=&quot;age&quot; /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;input type=&quot;submit&quot; /&gt;&lt;/p&gt;
&lt;/form&gt;</pre>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>POST</small></h2>
                <form action="examples/lesson14/post.php" method="POST" class="ajax">
                     <p>Your name: <input type="text" name="name" /></p>
                     <p>Your age: <input type="text" name="age" /></p>
                     <p><input type="submit" /></p>
                </form>
                <div class="result hide"></div>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>Files</small></h2>
                <p>
                    Utilizzando POST posso inviare qualsiasi tipo di contenuto, testuale o binario.
                </p>
                <div class="slide">
                    <p>Tramite form HTML posso allegare alla richiesta uno o più file.</p>
                    <ul>
                        <li>nessun limite teorico</li>
                        <li>accessibile dalla variabile <em>$_FILES</em></li>
                    </ul>
                </div>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>Files</small></h2>
                <p>
                    Limiti reali imposti dalla configurazione (<em>php.ini</em>)
                </p>
                <ul>
                    <li><strong>file_uploads</strong> on/off</li>
                    <li><strong>upload_max_filesize</strong></li>
                    <li><strong>post_max_size</strong></li>
                    <li><strong>max_file_uploads</strong></li>
                    <li><strong>max_input_time</strong> tempo di upload</li>
                </ul>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>Files</small></h2>
                <pre class="prettyprint lang-html">&lt;form enctype=&quot;multipart/form-data&quot; action=&quot;file.php&quot; method=&quot;POST&quot;&gt;
    Send this file: &lt;input name=&quot;userfile&quot; type=&quot;file&quot; /&gt;
    &lt;input type=&quot;submit&quot; value=&quot;Send File&quot; /&gt;
&lt;/form&gt;</pre>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>Files</small></h2>
                <form action="examples/lesson14/file.php" method="POST" class="ajaxfile">
                    <p>Save as: <input name="newname" type="text" /></p>
                    <p>Send this file: <input name="userfile" type="file" /></p>
                    <p><input type="submit" value="Send File" /></p>
                </form>
                <div class="result hide"></div>
            </section><section class="slide">
                <h2>Forms<br/><small>Files</small></h2>
                <p>
                    <strong>multipart/form-data</strong> modifica la codifica del contenuto della richiesta
                    <pre class="scroll">POST /slides/examples/lesson14/file.php HTTP/1.1
Content-Length: 39130
Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryGvQzFVXIoBDae9v8

------WebKitFormBoundaryGvQzFVXIoBDae9v8
Content-Disposition: form-data; name="newname"

test
------WebKitFormBoundaryGvQzFVXIoBDae9v8
Content-Disposition: form-data; name="userfile"; filename="report_video.png"
Content-Type: image/png


------WebKitFormBoundaryGvQzFVXIoBDae9v8--
</pre>
                </p>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>Files</small></h2>
                <p>
                    Per ciascun file allegato ho a disposizione
                </p>
                <ul>
                    <li><strong>name</strong>: nome originale del file</li>
                    <li><strong>type</strong>: <em>mime-type</em> del file (fornito dal browser)</li>
                    <li><strong>size</strong>: dimensione in byte</li>
                    <li><strong>tmp_name</strong>: percorso del file temporaneo</li>
                    <li><strong>error</strong>: <a href="http://php.net/manual/it/features.file-upload.errors.php" target="_blank">codice di errore</a> associato</li>
                </ul>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>File handling</small></h2>
                <p>
                    <strong>is_uploaded_file()</strong>: verifica se il file indicato proviene da un upload tramite form.
                </p>
                <p>
                    <strong>move_uploaded_file()</strong>: muove un file caricato in una nuova posizione sul server.
                </p>
                <p class="slide">Il file temporaneo viene in ogni caso rimosso automaticamente al termine dell'esecuzione della richiesta.</p>
            </section>
            <section class="slide">
                <h2>Forms<br/><small>Files</small></h2>
                <form action="examples/lesson14/file.php" method="POST" class="ajaxfile">
                    <p>userfile[]: <input name="userfile[]" type="file" /></p>
                    <p>userfile[]: <input name="userfile[]" type="file" /></p>
                    <p>anotherfile: <input name="anotherfile" type="file" /></p>
                    <p><input type="submit" value="Send File" /></p>
                </form>
                <div class="result hide"></div>
            </section>
            <section class="slide">
                <h2>Regular expressions</h2>
                <img class="slide" src="images/lesson14/regex.jpg" />
            </section>
            <section class="slide">
                <h2>Regular expressions</h2>
                <blockquote>
                    <p>una stringa che identifica un insieme di stringhe</p>
                </blockquote>
                <div class="slide">
                    <p>Utilizzo dei caratteri speciali per definire un <em>pattern</em></p>
                    <pre>// un indirizzo email
^[a-zA-Z0-9_-.]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$</pre>
                </div>
            </section>
            <section class="slide">
                <h2>Regular expressions<br/><small>PCRE</small></h2>
                <p>
                    Da PHP 5.3 l'unico formato supportato per le espressioni regolari è PCRE
                </p>
                <ul>
                    <li><em>pattern</em> racchiuso da un delimitatore </li>
                    <li>posso aggiungere modificatori (case-insensitive, multiline..)</li>
                </ul>
            </section>
            <section class="slide">
                <h2>Regular expressions<br/><small>Classi di caratteri</small></h2>
                <ul>
                    <li><strong>.</strong> qualsiasi carattere</li>
                    <li><strong>\w</strong> lettera (o underscore)</li>
                    <li><strong>\W</strong> non-lettera</li>
                    <li><strong>\d</strong> numero</li>
                    <li><strong>\D</strong> non-numero</li>
                    <li><strong>\s</strong> spazi (etc)</li>
                    <li><strong>\S</strong> non-spazi</li>
                    <li><strong>[aeiou]</strong> insieme di caratteri</li>
                    <li><strong>[^aeiou]</strong> insieme negato</li>
                    <li><strong>[g-s]</strong> range di valori</li>
                </ul>
            </section>
            <section class="slide">
                <h2>Regular expressions<br/><small>Quantificatori</small></h2>
                <p>Appesi ad un carattere (o classe di carattere)</p>
                <ul>
                    <li><strong>+</strong> uno o più</li>
                    <li><strong>*</strong> zero o più</li>
                    <li><strong>?</strong> uno o zero</li>
                    <li><strong>{1,3}</strong> quantità specifica</li>
                    <li><strong>|</strong> or logico <em>(a|e|i)</em></li>
                </ul>
            </section>
            <section class="slide">
                <h2>Regular expressions<br/><small>Gruppi</small></h2>
                <ul>
                    <li><strong>()</strong> "cattura" un gruppo</li>
                    <li><strong>\1</strong> referenza a un elemento "catturato"</li>
                </ul>
                <p>
                    ad esempio <em>(\w)a\1</em> identifica l'insieme formato da "dad", "gag" etc.
                </p>
            </section>
            <!-- End slides. -->

            <!-- Begin extension snippets. -->
            <!-- deck.status snippet -->
            <p class="deck-status" aria-role="status">
                <span class="deck-status-current"></span>
                /
                <span class="deck-status-total"></span>
            </p>
            <!-- deck.goto snippet -->
            <form action="." method="get" class="goto-form">
                <label for="goto-slide">Go to slide:</label>
                <input type="text" name="slidenum" id="goto-slide" list="goto-datalist">
                <datalist id="goto-datalist"></datalist>
                <input type="submit" value="Go">
            </form>
            <!-- End extension snippets. -->
        </div>
        <!-- Required JS files. -->
        <script src="jquery.min.js"></script>
        <script src="core/deck.core.js"></script>
        <!-- Extension JS files. -->
        <script src="extensions/menu/deck.menu.js"></script>
        <script src="extensions/goto/deck.goto.js"></script>
        <script src="extensions/status/deck.status.js"></script>
        <script src="extensions/navigation/deck.navigation.js"></script>
        <script src="extensions/scale/deck.scale.js"></script>
        <script src="extensions/events/deck.events.js"></script>
        <script src="extensions/step/deck.step.js"></script>
        <script src="extensions/anim/deck.anim.js"></script>
        <script src="extensions/google-code-prettify/prettify.js"></script>
        <script src="extensions/lessons.js"></script>
        <script type="text/javascript">
            $('form.ajax').submit(function (ev) {
                $this = $(this);
                var pre = $this.next("div.result");
                $.ajax({
                    type: $this.attr('method'),
                    url: $this.attr('action'),
                    data: $this.serialize(),
                    success: function (data) {
                        pre.html(data);
                        pre.removeClass('hide');
                    }
                });
                ev.preventDefault();
            });
            $('form.ajaxfile').submit(function (ev) {
                $this = $(this);
                var pre = $this.next("div.result");

                var formData = new FormData(this);
//                $this.find('input[type="file"]').each(function(idx, el) {
//                    formData.append($(el).attr('name'), $(el)[0].files[0]);
//                });
                $.ajax({
                    type: $this.attr('method'),
                    url: $this.attr('action'),
                    data : formData,
                    processData: false,
                    contentType: false,
                    success : function(data) {
                       pre.html(data);
                       pre.removeClass('hide');
                    }
                });
                ev.preventDefault();
            });
            $("").text( $( 'pre' ).html() );
        </script>
    </body>
</html>
