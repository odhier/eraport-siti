<div>
    <div class="title-section mb-3">
        Recently Accessed Courses
    </div>
    <div class="row">
        @foreach ($last_courses as $index=> $last_course)
        @if($index>=3) @break @endif
        <div class="col-4">
            <a href="/courses/{{$last_course->teacher_course->course->kode}}" class="hover:no-underline">

                <div class="course-card mb-3 last-course-1 p-3 bg-teal-{{ (2-$index+1)*100}} rounded-md">
                    <div class="row no-gutters">
                        <div class="col-3 d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{$last_course->teacher_course->course->kode}}&background=1D5F6A&size=70&length=4&font-size=0.3&rounded=true&color=fff" class="round" alt="">
                        </div>
                        <div class="col-9 d-flex align-items-center">
                            <div class="card-body py-0">
                                <h5 class="card-title uppercase text-black" style="font-size: 100%">{{$last_course->teacher_course->course->name}}</h5>
                                <p class="card-text"><small class="text-muted">{{$last_course->created_at->diffForHumans()}}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        @endforeach


    </div>
</div>
