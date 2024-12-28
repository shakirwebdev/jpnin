@section('page-script')
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<style>
    /*   
      SmartWizard 2.0 plugin 
      jQuery Wizard control Plugin
      by Dipu
      
      http://www.techlaboratory.net
      https://tech-laboratory.blogspot.com
    */
    .swMain {
      position:relative;
      display:block;
      margin:0;
      padding:0;
      border: 0px solid #CCC;
      overflow:visible;
      float:left;
      width:100%;
    }
    .swMain .stepContainer {
      display:block;
      position: relative;
      margin: 0;
      padding:0;    
      border: 0px solid #CCC;    
      overflow:hidden;
      clear:right;
      height:400px;
      width:79%;
      /*box-sizing:border-box;*/
    }

    .swMain .stepContainer div.content {
      display:block;
      position: absolute;  
      float:left;
      margin: 0;
      padding:5px;    
      border: 1px solid #CCC; 
      /*font: normal 12px Verdana, Arial, Helvetica, sans-serif; */
      color:#113f50;   
      background-color:#F8F8F8;  
      height:780px;
      text-align:left;
      overflow:auto;    
      z-index:88; 
      -webkit-border-radius: 5px;
      -moz-border-radius  : 5px;
      width:100%;
      box-sizing:border-box;
      clear:both;
    }

    .swMain div.actionBar {
      display:block;
      position: relative; 
      clear:right;
      margin:3px 0 0 0;   
      border:1px solid #CCC;
      padding:0;    
      color:#5A5655;   
      background-color:#F8F8F8;
      height:40px;
    /*  width:730px; 
      float:right; */  
      text-align:left;
      overflow:auto;    
      z-index:88; 
      -webkit-border-radius: 5px;
      -moz-border-radius  : 5px;

    }

    .swMain .stepContainer .StepTitle {
      display:block;
      position: relative;
      margin:0;   
      border:1px solid #E0E0E0;
      padding:5px;   
      font: bold 14px Verdana, Arial, Helvetica, sans-serif; 
      color:#113f50;   
      background-color:#E0E0E0;
      clear:both;
      text-align:left; 
      z-index:88;
      -webkit-border-radius: 5px;
      -moz-border-radius  : 5px;    
    }
    .swMain ul.anchor {
      position: relative;
      display:block;
      float:left;
      list-style: none;
      margin:0;
      padding: 0px;  
      border: 0px solid #CCCCCC;    
      background: transparent; /*#EEEEEE */
      width:21%;
      box-sizing:border-box;
    }
    .swMain ul.anchor li{ 
      position: relative; 
      display:block;
      margin: 0;
      padding: 0;
      padding-right:5px;
      padding-bottom: 5px;
      border: 0px solid #E0E0E0;      
      float: left;
      clear:both;
      width:100%;
      box-sizing:border-box;
    }
    /* Anchor Element Style */
    .swMain ul.anchor li a {
      display:block;
      position:relative;
      float:left;
      margin:0;
      padding:3px;
      height:90px;
      width:100%;
      box-sizing:border-box;
      text-decoration: none;
      outline-style:none;
      -moz-border-radius  : 5px;
      -webkit-border-radius: 5px;
      z-index:99;
    }
    .swMain ul.anchor li a .stepNumber{
      position:relative;
      float:left;
      width:30%;
      text-align: center;
      padding:5px;
      padding-top:0;
      font: bold 38px Verdana, Arial, Helvetica, sans-serif;
    }
    .swMain ul.anchor li a .stepDesc{
      position:relative;
      display:block;
      float:left;
      text-align: left;
      padding:5px;
      width:70%;
      font: bold 16px Verdana, Arial, Helvetica, sans-serif;
    }
    .swMain ul.anchor li a .stepDesc small{
      font: normal 10px Verdana, Arial, Helvetica, sans-serif;
    }
    .swMain ul.anchor li a.selected{
      color:#F8F8F8;
      background: #EA8511;  /* EA8511 */
      border: 1px solid #EA8511;
      cursor:text;
      -moz-box-shadow: 1px 5px 10px #888;
      -webkit-box-shadow: 1px 5px 10px #888;
      box-shadow: 1px 5px 10px #888;
    }
    .swMain ul.anchor li a.selected:hover {
      color:#F8F8F8;  
      background: #EA8511;  
    }

    .swMain ul.anchor li a.done { 
      position:relative;
      color:#FFF;  
      background: #113f50;  
      border: 1px solid #157ca2;   
      z-index:99;
    }
    .swMain ul.anchor li a.done:hover {
      color:#ffffff;  
      background: #157ca2; 
      border: 1px solid #5A5655;   
    }
    .swMain ul.anchor li a.disabled {
      color:#CCCCCC;  
      background: #F8F8F8;
      border: 1px solid #CCC;  
      cursor:text;   
    }
    .swMain ul.anchor li a.disabled:hover {
      color:#CCCCCC;  
      background: #F8F8F8;     
    }

    .swMain ul.anchor li a.error {
      color:#6c6c6c !important;  
      background: #f08f75 !important;
      border: 1px solid #fb3500 !important;      
    }
    .swMain ul.anchor li a.error:hover {
      color:#000 !important;       
    }

    .swMain .buttonNext {
      display:block;
      float:right;
      margin:5px 3px 0 3px;
      padding:5px;
      text-decoration: none;
      text-align: center;
      font: bold 13px Verdana, Arial, Helvetica, sans-serif;
      width:100px;
      color:#FFF;
      outline-style:none;
      background-color:   #5A5655;
      border: 1px solid #5A5655;
      -moz-border-radius  : 5px; 
      -webkit-border-radius: 5px;    
    }
    .swMain .buttonDisabled {
      color:#F8F8F8  !important;
      background-color: #CCCCCC !important;
      border: 1px solid #CCCCCC  !important;
      cursor:text;    
    }
    .swMain .buttonPrevious {
      display:block;
      float:right;
      margin:5px 3px 0 3px;
      padding:5px;
      text-decoration: none;
      text-align: center;
      font: bold 13px Verdana, Arial, Helvetica, sans-serif;
      width:100px;
      color:#FFF;
      outline-style:none;
      background-color:   #5A5655;
      border: 1px solid #5A5655;
      -moz-border-radius  : 5px; 
      -webkit-border-radius: 5px;    
    }
    .swMain .buttonFinish {
      display:block;
      float:right;
      margin:5px 10px 0 3px;
      padding:5px;
      text-decoration: none;
      text-align: center;
      font: bold 13px Verdana, Arial, Helvetica, sans-serif;
      width:100px;
      color:#FFF;
      outline-style:none;
      background-color:   #5A5655;
      border: 1px solid #5A5655;
      -moz-border-radius  : 5px; 
      -webkit-border-radius: 5px;    
    }

    /* Form Styles */

    .txtBox {
      border:1px solid #CCCCCC;
      color:#5A5655;
      font:13px Verdana,Arial,Helvetica,sans-serif;
      padding:2px;
      width:430px;
    }
    .txtBox:focus {
      border:1px solid #EA8511;
    }

    .swMain .loader {
      position:relative;  
      display:none;
      float:left;  
      margin: 2px 0 0 2px;
      padding:8px 10px 8px 40px;
      border: 1px solid #FFD700; 
      font: bold 13px Verdana, Arial, Helvetica, sans-serif; 
      color:#5A5655;       
      background: #FFF url(../images/loader.gif) no-repeat 5px;  
      -moz-border-radius  : 5px;
      -webkit-border-radius: 5px;
      z-index:998;
    }
    .swMain .msgBox {
      position:absolute;  
      display:none;
      float:left;
      margin: 4px 0 0 5px;
      padding:5px;
      border: 1px solid #FFD700; 
      background-color: #FFFFDD;  
      font: normal 12px Verdana, Arial, Helvetica, sans-serif; 
      color:#5A5655;         
      -moz-border-radius  : 5px;
      -webkit-border-radius: 5px;
      z-index:999;
      min-width:200px;  
    }
    .swMain .msgBox .content {
      font: normal 12px Verdana,Arial,Helvetica,sans-serif;
      padding: 0px;
      float:left;
    }
    .swMain .msgBox .close {
      border: 1px solid #CCC;
      border-radius: 3px;
      color: #CCC;
      display: block;
      float: right;
      margin: 0 0 0 5px;
      outline-style: none;
      padding: 0 2px 0 2px;
      position: relative;
      text-align: center;
      text-decoration: none;
    }
    .swMain .msgBox .close:hover{
      color: #EA8511;
      border: 1px solid #EA8511;  
    }
</style>
<style type="text/css">
	.series-frame {
	  /*max-width: 600px;*/
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	  box-sizing: border-box;
	  border: 2px solid #113f50;
	  /*margin: 30px;*/
	  padding: 10px;
	}
</style>
<script type="text/javascript">
	/* SmartWizard 2.0 plugin
   * jQuery Wizard control Plugin
   * http://www.techlaboratory.net/smartwizard
   * 
   * by Dipu Raj  
   * http://dipuraj.me
   * 
   * License 
   * https://github.com/techlab/SmartWizard/blob/master/MIT-LICENSE.txt 
   */
   (function(a) {
      	a.fn.smartWizard = function(m) {
          	var c = a.extend({}, a.fn.smartWizard.defaults, m),
              	x = arguments;
          	return this.each(function() {
              function C() {
                  var e = b.children("div");
                  b.children("ul").addClass("anchor");
                  e.addClass("content");
                  n = a("<div>Loading</div>").addClass("loader");
                  k = a("<div></div>").addClass("actionBar");
                  p = a("<div></div>").addClass("stepContainer");
                  q = a("<a>" + c.labelNext + "</a>").attr("href", "#").addClass("buttonNext");
                  r = a("<a>" + c.labelPrevious + "</a>").attr("href", "#").addClass("buttonPrevious");
                  s = a("<a>" + c.labelFinish + "</a>").attr("href", "#").addClass("buttonFinish");
                  c.errorSteps && 0 < c.errorSteps.length && a.each(c.errorSteps, function(a, b) {
                      y(b, !0)
                  });
                  p.append(e);
                  k.append(n);
                  b.append(p);
                  b.append(k);
                  c.includeFinishButton && k.append(s);
                  k.append(q).append(r);
                  z = p.width();
                  a(q).click(function() {
                      if (a(this).hasClass("buttonDisabled")) return !1;
                      A();
                      return !1
                  });
                  a(r).click(function() {
                      if (a(this).hasClass("buttonDisabled")) return !1;
                      B();
                      return !1
                  });
                  a(s).click(function() {
                      if (!a(this).hasClass("buttonDisabled"))
                          if (a.isFunction(c.onFinish)) c.onFinish.call(this,
                              a(f));
                          else {
                              var d = b.parents("form");
                              d && d.length && d.submit()
                          }
                      return !1
                  });
                  a(f).bind("click", function(a) {
                      if (f.index(this) == h) return !1;
                      a = f.index(this);
                      1 == f.eq(a).attr("isDone") - 0 && t(a);
                      return !1
                  });
                  c.keyNavigation && a(document).keyup(function(a) {
                      39 == a.which ? A() : 37 == a.which && B()
                  });
                  D();
                  t(h)
              }

              function D() {
                  c.enableAllSteps ? (a(f, b).removeClass("selected").removeClass("disabled").addClass("done"), a(f, b).attr("isDone", 1)) : (a(f, b).removeClass("selected").removeClass("done").addClass("disabled"), a(f, b).attr("isDone",
                      0));
                  a(f, b).each(function(e) {
                      a(a(this).attr("href"), b).hide();
                      a(this).attr("rel", e + 1)
                  })
              }

              function t(e) {
                  var d = f.eq(e),
                      g = c.contentURL,
                      h = d.data("hasContent");
                  stepNum = e + 1;
                  g && 0 < g.length ? c.contentCache && h ? w(e) : a.ajax({
                      url: g,
                      type: "POST",
                      data: {
                          step_number: stepNum
                      },
                      dataType: "text",
                      beforeSend: function() {
                          n.show()
                      },
                      error: function() {
                          n.hide()
                      },
                      success: function(c) {
                          n.hide();
                          c && 0 < c.length && (d.data("hasContent", !0), a(a(d, b).attr("href"), b).html(c), w(e))
                      }
                  }) : w(e)
              }

              function w(e) {
                  var d = f.eq(e),
                      g = f.eq(h);
                  if (e != h && a.isFunction(c.onLeaveStep) &&
                      !c.onLeaveStep.call(this, a(g))) return !1;
                  c.updateHeight && p.height(a(a(d, b).attr("href"), b).outerHeight());
                  if ("slide" == c.transitionEffect) a(a(g, b).attr("href"), b).slideUp("fast", function(c) {
                      a(a(d, b).attr("href"), b).slideDown("fast");
                      h = e;
                      u(g, d)
                  });
                  else if ("fade" == c.transitionEffect) a(a(g, b).attr("href"), b).fadeOut("fast", function(c) {
                      a(a(d, b).attr("href"), b).fadeIn("fast");
                      h = e;
                      u(g, d)
                  });
                  else if ("slideleft" == c.transitionEffect) {
                      var k = 0;
                      e > h ? (nextElmLeft1 = z + 10, nextElmLeft2 = 0, k = 0 - a(a(g, b).attr("href"), b).outerWidth()) :
                          (nextElmLeft1 = 0 - a(a(d, b).attr("href"), b).outerWidth() + 20, nextElmLeft2 = 0, k = 10 + a(a(g, b).attr("href"), b).outerWidth());
                      e == h ? (nextElmLeft1 = a(a(d, b).attr("href"), b).outerWidth() + 20, nextElmLeft2 = 0, k = 0 - a(a(g, b).attr("href"), b).outerWidth()) : a(a(g, b).attr("href"), b).animate({
                          left: k
                      }, "fast", function(e) {
                          a(a(g, b).attr("href"), b).hide()
                      });
                      a(a(d, b).attr("href"), b).css("left", nextElmLeft1);
                      a(a(d, b).attr("href"), b).show();
                      a(a(d, b).attr("href"), b).animate({
                          left: nextElmLeft2
                      }, "fast", function(a) {
                          h = e;
                          u(g, d)
                      })
                  } else a(a(g,
                      b).attr("href"), b).hide(), a(a(d, b).attr("href"), b).show(), h = e, u(g, d);
                  return !0
              }

              function u(e, d) {
                  a(e, b).removeClass("selected");
                  a(e, b).addClass("done");
                  a(d, b).removeClass("disabled");
                  a(d, b).removeClass("done");
                  a(d, b).addClass("selected");
                  a(d, b).attr("isDone", 1);
                  c.cycleSteps || (0 >= h ? a(r).addClass("buttonDisabled") : a(r).removeClass("buttonDisabled"), f.length - 1 <= h ? a(q).addClass("buttonDisabled") : a(q).removeClass("buttonDisabled"));
                  !f.hasClass("disabled") || c.enableFinishButton ? a(s).removeClass("buttonDisabled") :
                      a(s).addClass("buttonDisabled");
                  if (a.isFunction(c.onShowStep) && !c.onShowStep.call(this, a(d))) return !1
              }

              function A() {
                  var a = h + 1;
                  if (f.length <= a) {
                      if (!c.cycleSteps) return !1;
                      a = 0
                  }
                  t(a)
              }

              function B() {
                  var a = h - 1;
                  if (0 > a) {
                      if (!c.cycleSteps) return !1;
                      a = f.length - 1
                  }
                  t(a)
              }

              function E(b) {
                  a(".content", l).html(b);
                  l.show()
              }

              function y(c, d) {
                  d ? a(f.eq(c - 1), b).addClass("error") : a(f.eq(c - 1), b).removeClass("error")
              }
              var b = a(this),
                  h = c.selected,
                  f = a("ul > li > a[href^='#step-']", b),
                  z = 0,
                  n, l, k, p, q, r, s;
              k = a(".actionBar", b);
              0 == k.length && (k =
                  a("<div></div>").addClass("actionBar"));
              l = a(".msgBox", b);
              0 == l.length && (l = a('<div class="msgBox"><div class="content"></div><a href="#" class="close">X</a></div>'), k.append(l));
              a(".close", l).click(function() {
                  l.fadeOut("normal");
                  return !1
              });
              if (m && "init" !== m && "object" !== typeof m) {
                  if ("showMessage" === m) {
                      var v = Array.prototype.slice.call(x, 1);
                      E(v[0]);
                      return !0
                  }
                  if ("setError" === m) return v = Array.prototype.slice.call(x, 1), y(v[0].stepnum, v[0].iserror), !0;
                  a.error("Method " + m + " does not exist")
              } else C()
          })
      };
      a.fn.smartWizard.defaults = {
          selected: 0,
          keyNavigation: !0,
          enableAllSteps: !1,
          updateHeight: !0,
          transitionEffect: "fade",
          contentURL: null,
          contentCache: !0,
          cycleSteps: !1,
          includeFinishButton: !0,
          enableFinishButton: !1,
          errorSteps: [],
          labelNext: "Seterusnya",
          labelPrevious: "Kembali",
          labelFinish: "Hantar",
          onLeaveStep: null,
          onShowStep: null,
          onFinish: null
      }
  })(jQuery);


    $(document).ready( function () {
    	// Smart Wizard
    	$('#wizard').smartWizard({
          	transitionEffect: 'slideleft',
          	onFinish: onFinishCallback
      	});

      	function onFinishCallback(e){
    		$('#wizard').smartWizard('showMessage','All Step Done.. !!!');
        	e.preventDefault;
        
	    }
    	
    	$('#senarai_kaum_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#sosio_ekomomi_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#jenis_rumah_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#jenis_pertubuhan_table').DataTable( {
    		processing: true,
        	// serverSide: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	        data: dataSetPertubuhan,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1"><span class="custom-control-label">&nbsp;</span></label>';
                	return button_a;
                    }
                },
	        ]
	    });

	    $('#parti_politik_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#kemudahan_awam_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#kes_jenayah_table').DataTable( {
    		processing: true,
        	// serverSide: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	        data: dataSetJenayah,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1"><span class="custom-control-label">&nbsp;</span></label>';
                	return button_a;
                    }
                },
	        ]
	    });

	    $('#masalah_sosial_table').DataTable( {
    		processing: true,
        	// serverSide: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	        data: dataSetSosial,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1"><span class="custom-control-label">&nbsp;</span></label>';
                	return button_a;
                    }
                },
	        ]
	    });

	    $('#kawasan_pertanian_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#ahli_jawatankuasa_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#nama_kehadiran_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#summernote_1').summernote({
	        height: 400
	    });

	    $('#summernote_2').summernote({
	        height: 400
	    });

	    $('#cadangan_persempadanan_table').DataTable( {
    		processing: true,
        	// serverSide: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	        data: dataSetPersempadanan,
		    columns: [
	            {bSortable: false, sClass: 'text-center'},
	            {bSortable: false},
	            {data : null, bSortable: false, sClass: 'text-center',
                    mRender: function (value, type, full) {
                    	button_a = '<label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1"><span class="custom-control-label">&nbsp;</span></label>';
                	return button_a;
                    }
                },
	        ]
	    });

	    $('#soal_jawab_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#ahli_jawatankuasa_krt_table').DataTable( {
    		processing: true,
        	"language": {
	            "paginate": {
	                "previous": "Sebelumnya",
	                "next": "Seterusnya",
	                searchPanes: {
		                emptyPanes: 'There are no panes to display. :/'
		            }
	            },
	            "sSearch": "Carian",
	            "sLengthMenu": "Paparan _MENU_ rekod",
	            "lengthMenu": "Paparan _MENU_ rekod setiap laman",
	            "zeroRecords": "Tiada rekod ditemui",
	            "info": "Paparan laman _PAGE_ dari _PAGES_ daripada _TOTAL_ rekod",
	            "infoEmpty": "",
	            "infoFiltered": "(diisih dari _MAX_ keseluruhan rekod)"
        	},
        	dom: 'rtip',
        	"bFilter": true,
        	responsive: true,
	    });

	    $('#summernote_3').summernote({
	        height: 400
	    });
        
    });

	var dataSetPertubuhan = [ 
		["1","MPP"],
		["2","MPKK"],
		["3","Persatuan Penduduk"],
		["4","Joint Management Body (JMB)"],
		["5","Lain-lain : (Contoh :Rela, Persatuan Belia, Community Policing dan sebagainya)"]
	];

	var dataSetJenayah = [ 
		["1","Pecah Rumah / Pecah Kenderaan"],
		["2","Ragut / Rompakan"],
		["3","Pengedaran / Penagihan Dadah"],
		["4","Pergaduhan / Gengster"],
		["5","Lumba Haram"],
		["6","Lain-lain (sila nyatakan di ruangan berikut"]
	];

	var dataSetSosial = [ 
		["1","Lepak"],
		["2","Perjudian"],
		["3","Minum Arak / Samsu Haram"],
		["4","Pelacuran"],
		["5","Vandalisme"],
		["6","Ponteng Sekolah"],
		["7","Lesbian Gay Biseksual Transgender"],
		["8","Lumba Haram"],
		["9","Sumbang Mahram"],
		["10","Bohsia dan Bohjan"],
		["11","Lain-lain (Sila nyatakan di ruangan berikut)"],
	];

	var dataSetPersempadanan = [ 
		["1","Penerangan mengenai Jabatan Perpaduan Negara dan Integrasi Nasional dan Rukun Tetangga"],
		["2","Fungsi dan tanggungjawab Rukun Tetangga termasuk Jiran Wanita, Jiran Muda, Jiran Warga Emas, Tunas Jiran dan Skim Rondaan Sukarela"],
		["3","Cadangan persempadanan Kawasan Rukun Tetangga"]
	];
    
</script>

<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/dialogs.js') }}"></script>

<script src="../assets/bundles/dataTables.bundle.js"></script>
<script src="assets/js/table/datatable.js"></script>

<script src="../assets/plugins/dropify/js/dropify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@stop