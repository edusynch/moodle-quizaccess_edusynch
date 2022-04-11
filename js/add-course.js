var addCourseTemplate = `
  <div id="addCourse">
    <h6 class="text-black-50 mb-4 font-weight-bold mt-3" style="font-size: 20px;">
      Add Course
      <span class="font-weight-normal" style="font-size: 14px;"> (For save)</span>
    </h6>
    <div class="course pb-2">
      <div class="course-header mb-1">
        <div class="row">
          <div class="col-sm-4">
            <h6 class="font-weight-bold text-black-50">Course</h6>
          </div>
          <div class="col-sm-4">
            <h6 class="font-weight-bold text-black-50">Quiz</h6>
          </div>
        </div>
      </div>
      <div class="border-top w-75 mb-4"></div>
    </div>
  </div>
`;

var courseFormRowTemplate = `
<div class="course-form-row">
  <div class="row">
    <div class="col-sm-4">
      <select name="course" class="form-control" data-live-search="true"></select>
    </div>
    <div class="col-sm-4">
      <select name="quizzes[]" class="form-control" data-live-search="true" disabled></select>
    </div>
    <div class="col">
      <button class="btn btn-outline-danger btn-delete">
        <i class="fa fa-trash"></i>
      </button>
    </div>
  </div>
  <div class="col-sm-12 border-bottom w-75 my-4"></div>
</div>
`;

var btnAddCourse = $('#btnAddCourse');
var btnDeleteCourse = $('.btn-delete');
var addCourseContainer = $('#addCourseContainer');
var isAddingCourse = false;
var courses = [];

$(document).ready(function() {
  var coursesSelectFilter = $('select[name="filter-course"]');

  getCourses(function(coursesJson) {
    courses = coursesJson;
    populateSelectElement(coursesSelectFilter, courses);
  });

  $('.btn-delete-quiz').on('click', function() {
    var quizId = $(this).attr('data-quiz');
    $('[type=hidden][value='+quizId+']').remove();
    $('tr#quiz-'+quizId).remove();
  }); 
});

btnAddCourse.click(function() {
  if (isAddingCourse) {
    addCourseFormRowTemplate();
  } else {
    initializeCourseForm();
  }
});

function addCourseFormRowTemplate() {
  $(courseFormRowTemplate).appendTo(addCourseContainer);

  loadCoursesSelect();
  initializeDeleteCourseRow();
};

function loadCoursesSelect() {
  var coursesSelect = $(addCourseContainer).children().last().find('select[name="course"]');

  $(coursesSelect).change(selectCourse);

  $('<option value="">Select Course</option>').appendTo(coursesSelect);

  if (!courses.length) {
    getCourses(function(coursesJson) {
      courses = coursesJson;
      populateSelectElement(coursesSelect, courses);
    });
  } else {
    populateSelectElement(coursesSelect, courses);
  }
}

function populateSelectElement(selectElement, options) {
  if (options.length) {
    options.forEach((option) => {
      $(`<option value="${option.id}">${option.name || option.title || option.description}</option>`).appendTo(selectElement);
    });
  }

}

function selectCourse(event) {
  var courseId = event.target.value;
  
  if (!courseId) return;

  getQuizzesByCourseId(courseId, function(quizzes) {
    loadQuizzesSelect(quizzes, event);
  });
}

function loadQuizzesSelect(quizzes, event) {
  var quizzesSelect = $(event.target).parent().parent().parent().find('select[name="quizzes\[\]"]');

  $(quizzesSelect).empty();
  $(quizzesSelect).prop('disabled', false);

  $('<option value="">Select Quiz</option>').appendTo(quizzesSelect);

  populateSelectElement(quizzesSelect, quizzes);
}

function initializeCourseForm() {
  $(addCourseTemplate).appendTo(addCourseContainer);
  addCourseFormRowTemplate();

  isAddingCourse = true;
}

function initializeDeleteCourseRow() {
  $('.btn-delete').click(deleteCourse);
}

function deleteCourse() {
  $($(this).parent().parent().parent()).remove();

  if (!$('.btn-delete').get(0)) {
    $('#addCourse').remove();

    isAddingCourse = false;
  }
}

function getCourses(callback) {
  fetch('ajax.php?action=courses')
    .then(response => response.json())
    .then(callback);
}

function getQuizzesByCourseId(courseId, callback) {
  fetch(`ajax.php?action=quizzes&course=${courseId}`)
    .then(response => response.json())
    .then(callback);
}