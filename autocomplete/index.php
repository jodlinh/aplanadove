<!DOCTYPE html>
<html>
<head>
  <title>PHP - Jquery Chosen Ajax Autocomplete Example - ItSolutionStuff.com</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="/chosen/chosen.css" />
  <script src="/chosen/chosen.jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="/js/typeahead/typeahead.jquery.js"></script>
</head>
<body>

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">select</div>
    <div class="panel-body">
      <form action="#">
        <select class="form-control select-box" data-placeholder="Buscar Producto">
          <option></option>
        </select>
      </form>
    </div>
  </div>
</div> 


<div id="the-basics">
  <input class="typeahead" type="text" placeholder="States of USA">
</div>

<script type="text/javascript">
  $(".select-box").chosen({no_results_text:'No hay resultados para '});
  

  
 // $(".select-box").chosen();

  $('.chosen-search input').autocomplete({
    source: function( request, response ) {
      $.ajax({
        url: "ajaxpro.php?name="+request.term,
        dataType: "json",
        success: function( data ) {
          $('.select-box').empty();
          response( $.map( data, function( item ) {
            $('.select-box').append('<option value="'+item.id+'">' + item.name + '</option>');
          }));
          $(".select-box").trigger("chosen:updated");
          
        }
      });
    }
  });




  var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;

    // an array that will be populated with substring matches
    matches = [];

    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');

    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
};

var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
  'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
  'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
  'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
  'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
  'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
  'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
  'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
  'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
];

$('#the-basics .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'states',
  source: substringMatcher(states)
});
</script>
</body>
</html>