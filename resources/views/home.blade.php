@extends('layouts.app')

@section('title', 'Home')


@section('content')
    <div class="snap-center min-h-96 bg-purple-100 mt-14 py-8 relative overflow-hidden bg-fixed bg-blend-soft-light	flex items-center"
        style="background-image: url({{ asset('assets/image/boxs.webp') }})">
        <div class="container mx-auto px-4">

            <div class="flex justify-between gap-4 flex-col-reverse md-flex-col md:flex-row items-center">
                <div class="text-center md:text-start">
                    <p class="font-bold text-2xl mb-4 italic">Let's Start To Build Our Business</p>
                    <p class=" text-xl ">Hi, I'm <b>Thomas, A Backend Developer,</b></p>
                    <p class="text-lg">And This Is My Favorite Hobby </p>
                </div>
                <img src="{{ asset('assets/image/first.png') }}" alt="image pc" class="w-2/3 md:w-2/5">
            </div>
        </div>
    </div>
    <div class="snap-center bg-purple-50/2 py-14">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">What We Got Here</h1>
                <p class="text-lg">You will get all our knowledge and technological expertise</p>
            </div>
            <div class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] justify-center gap-4">
                <div
                    class="bg-white shadow flex gap-2 items-center p-2 py-4 rounded-lg duration-300 hover:-translate-y-2 cursor-pointer">
                    <div class="p-1 rounded-lg border ">
                        <img src="{{ asset('assets/image/icons/fastTime.jpg') }}" class="w-16"
                            alt="icon fast time to arrive">
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Fast Site</h3>
                        <p class="text-sm">The most important thing is to perform well</p>
                    </div>
                </div>
                <div
                    class="bg-white shadow flex gap-2 items-center p-2 py-4 rounded-lg duration-300 hover:-translate-y-2 cursor-pointer">
                    <div class="p-1 rounded-lg border ">
                        <img src="{{ asset('assets/image/icons/verification.jpg') }}" class="w-16"
                            alt="icon fast time to arrive">
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Verification</h3>
                        <p class="text-sm">You have to secure the site because you don't know what the customer is doing</p>
                    </div>
                </div>
                <div
                    class="bg-white shadow flex gap-2 items-center p-2 py-4 rounded-lg duration-300 hover:-translate-y-2 cursor-pointer">
                    <div class="p-1 rounded-lg border ">
                        <img src="{{ asset('assets/image/icons/code.jpg') }}" class="w-16" alt="icon fast time to arrive">
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Clean coding</h3>
                        <p class="text-sm">Simple and understandable code for everyone</p>
                    </div>
                </div>
                <div
                    class="bg-white shadow flex gap-2 items-center p-2 py-4 rounded-lg duration-300 hover:-translate-y-2 cursor-pointer">
                    <div class="p-1 rounded-lg border ">
                        <img src="{{ asset('assets/image/icons/time.jpg') }}" class="w-16" alt="icon fast time to arrive">
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">on The time</h3>
                        <p class="text-sm">Delivery ahead of schedule too!!</p>
                    </div>
                </div>
                <div
                    class="bg-white shadow flex gap-2 items-center p-2 py-4 rounded-lg duration-300 hover:-translate-y-2 cursor-pointer">
                    <div class="p-1 rounded-lg border ">
                        <img src="{{ asset('assets/image/icons/message.jpg') }}" class="w-16"
                            alt="icon fast time to arrive">
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Anytime we are here</h3>
                        <p class="text-sm">Send to us and soon you will know the answer</p>
                    </div>
                </div>
                <div
                    class="bg-white shadow flex gap-2 items-center p-2 py-4 rounded-lg duration-300 hover:-translate-y-2 cursor-pointer">
                    <div class="p-1 rounded-lg border ">
                        <img src="{{ asset('assets/image/icons/laravel.png') }}" class="w-16"
                            alt="icon fast time to arrive">
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Latest technology</h3>
                        <p class="text-sm">What distinguishes this framework is that it is simple and strong in security</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="snap-center bg-purple-100 py-14">
        <div class="container mx-auto px-4 ">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">What are my skills?</h1>
                <p class="text-lg">This is not all I know for sure but this is what you need to know</p>
            </div>
            <div class="flex gap-4 justify-center flex-wrap">
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/html.png') }}" class="w-6" alt="Html">
                    <span>HTML</span>
                </div>
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/css.png') }}" class="w-6" alt="Css">
                    <span>Css</span>
                </div>
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/js.png') }}" class="w-6" alt="JavaScript ">
                    <span>JavaScript </span>
                </div>
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/bootstrap.png') }}" class="w-6" alt="Bootstrap">
                    <span>Bootstrap</span>
                </div>
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/tailwind.png') }}" class="w-6" alt="Tailwind">
                    <span>Tailwind</span>
                </div>
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/php.png') }}" class="w-6" alt="PHP">
                    <span>PHP</span>
                </div>
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/mysql.png') }}" class="w-6" alt="MySQL">
                    <span>MySQL</span>
                </div>
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/laravel.png') }}" class="w-6" alt="Laravel">
                    <span>Laravel</span>
                </div>
                <div class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/livewire.png') }}" class="w-6" alt="Livewire">
                    <span>Livewire</span>
                </div>
                <div
                    class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/oop.png') }}" class="w-6" alt="OOP">
                    <span>OOP</span>
                </div>
                <div
                    class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/git.png') }}" class="w-6" alt="Git">
                    <span>Git</span>
                </div>
                <div
                    class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/illustrator.png') }}" class="w-6" alt="illustrator">
                    <span>illustrator</span>
                </div>
                <div
                    class="flex gap-2 items-center bg-white shadow py-2 px-4 rounded-lg duration-300 hover:-translate-y-1">
                    <img src="{{ asset('assets/image/icons/api.png') }}" class="w-16" alt="API">
                    <span>API</span>
                </div>
            </div>
        </div>
    </div>
    <div class="snap-center bg-purple-50/2 py-14" id="projects">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">My Last Projects</h1>
                <p class="text-lg">These are my latest projects, just a few but they mean a lot</p>
            </div>
            @if ($projects->count() > 0)
                <div class="projects grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] justify-center gap-4">
                    @foreach ($projects as $project)
                        <div data-drawer-target="show-project" data-drawer-show="show-project"
                            aria-controls="show-project" data-id='{{ $project->id }}'
                            class="box cursor-pointer relative border-4 border-white overflow-hidden rounded-xl h-48 duration-300 hover:opacity-90 group">
                            <img src="{{ Storage::url('projects/' . $project->attachments()->where('banner', true)->first()->attachment) }}"
                                class="w-screen h-full" alt="{{ $project->title }}">
                            <div
                                class="absolute inset-0 flex flex-col justify-between items-end p-4 z-1 translate-x-full duration-300 group-hover:translate-x-0">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($project->skills as $skill)
                                        <span class="bg-gray-900/75 py-1 px-2 rounded-lg">
                                            <img src="{{ asset('assets/image/icons/' . $skill->img) }}" class="w-6"
                                                alt="{{ $skill->name }}">
                                        </span>
                                    @endforeach

                                </div>
                                <div class="bg-gray-900/75 py-1 px-2 rounded-lg text-white font-bold">
                                    {{ Str::limit($project->title, 16, '...') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button
                    class="showMore block w-fit mx-auto text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    See More
                </button>
            @else
                <p class="text-center italic">it's seem, Thomas don't added any project</p>
            @endif
        </div>
    </div>
    <x-sidebar-modal id='show-project' />

    <div class="snap-center bg-purple-100 py-8">
        <div class="container mx-auto px-2 italic text-center font-bold">
            "We are programmers. Everything he created can be made by everyone, but you do not have the right to take what
            he made without permission.."
        </div>
    </div>

    <div class="snap-center bg-purple-50/2 py-14" id="feedbacks">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold">Testimonials</h1>
                <p class="text-lg">Previous clients' opinions about working with us</p>
            </div>
            @if ($feedbacks->count() > 0)
                <x-slider>
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-56">
                        @foreach ($feedbacks as $feedback)
                            <!-- Item 1 -->
                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                <div class="flex justify-center p-4">
                                    <div class="bg-gray-50 rounded-xl shadow-lg p-4 w-2/3 h-full">
                                        <div class="flex justify-between items-center gap-2">
                                            <div class="flex gap-2 items-center">
                                                <img src="{{ asset('assets/image/user.png') }}" alt="icon user ignore"
                                                    class="w-12 rounded-full">
                                                <div>
                                                    <h5 class="font-bold text-lg">{{ $feedback->name }}</h5>
                                                    <span>{{ $feedback->platform }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ $feedback->link }}" target="_blank">
                                                <img src="{{ asset('assets/image/' . $feedback->platform . '.png') }}"
                                                    alt="{{ $feedback->platform }} project" class="w-20">
                                            </a>
                                        </div>
                                        <hr class="my-4">
                                        <p class="italic font-bold break-words">
                                            "{{ $feedback->message }}"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        @for ($i = 0; $i < $feedbacks->count(); $i++)
                            <button type="button" class="w-3 h-3 rounded-full" aria-current="true"
                                aria-label="Slide {{ $i }}"
                                data-carousel-slide-to="{{ $i }}"></button>
                        @endfor
                    </div>
                </x-slider>
            @else
                <p class="text-center italic">it's seem no one added any feedback</p>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {


            $('.projects .box').on('click', function() {
                $('.loader').css('display', 'flex');
                $('#show-project .content').empty()
                $.ajax({
                    type: 'GET',
                    url: "{{ route('project.show', '') }}/" + $(this).data('id'),
                    contentType: "application/json"
                }).done(function(response) {
                    $('#show-project .title-project').text(response.title);
                    $('#show-project .content').append(`
                    <x-slider>
                        <div class="relative h-56 overflow-hidden rounded-lg md:h-56">
                            ${
                              response.attachments.map(image => {
                                return `
                                                                                                                                                                          <!-- Item -->
                                                                                                                                                                          <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                                                                                                                                              <img src="{{ Storage::url('projects/${image.attachment}') }}"
                                                                                                                                                                                  class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                                                                                                                                                          </div>
                                                                                                                                                                        `
                              }).join('')
                            }

                        </div>
                        <!-- Slider indicators -->
                        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                          ${
                            response.attachments.map((image, index) => {
                              return `
                                                                                                                                                                                      <button type="button" class="w-3 h-3 rounded-full" aria-current="true"
                                                                                                                                                                                          aria-label="Slide ${index + 1}"
                                                                                                                                                                                          data-carousel-slide-to="${index}"></button>
                                                                                                                                                                                    `
                            }).join('')
                          }

                        </div>
                    </x-slider>
                    <div class="flex justify-between gap-2 items-center flex-wrap border-y-2 p-2">
                        <div class='flex flex-col'>
                          <h3 class="font-bold text-lg text-gray-900 word-nowrap">${response.title}</h3>
                          <span class='text-sm text-gray-600'>${response.published_at}</span>
                        </div>
                        <div class="flex gap-2 items-center justify-between">
                            ${
                              response.type == 'professional' ? `
                                                <a title="${response.platform} Platform">
                                                    <img src="{{ asset('assets/image/${response.platform}.png') }}" class="w-16" alt="${response.platform} icon">
                                                </a>
                                            ` : ''
                            }
                            <div class='flex gap-2'>
                              ${
                                response.github ? `
                                                                              <a href="${response.github}" title="Github" target="_blank">
                                                                                  <img src="{{ asset('assets/image/icons/github.png') }}" class="w-8" alt="github icon">
                                                                              </a>
                                                                              ` : ''
                              }
                              ${
                                response.preview ? `
                                                                                  <a href="${response.preview}" target="_blank"
                                                                                      class="inline-block text-white bg-purple-600 hover:bg-purple-700 duration-300 text-sm font-bold py-2 px-4 rounded-xl">
                                                                                      Visit here
                                                                                  </a>
                                                                                ` : ''
                              }
                            </div>
                        </div>
                    </div>
                    <div class="py-2 border-b-2 flex gap-2 items-center justify-center flex-wrap">
                      ${
                        response.skills.map(skill => {
                        return   `
                                                                          <div class="bg-gray-900/20 py-2 px-4 rounded-xl duration-300 hover:-translate-y-1 cursor-pointer" title='${skill.name}'>
                                                                              <img src="{{ asset('assets/image/icons/${skill.img}') }}" class="w-4" alt="${skill.name}">
                                                                          </div>
                                                                        `
                        }).join('')
                      }
                    </div>
                    <div class="py-2">
                        <h3 class="font-bold text-lg text-gray-900 word-nowrap">What is this project about?</h3>
                        <div class="text-gray-700 whitespace-pre-line">
                            ${response.description}
                        </div>
                    </div>
                `);

                    console.log(response);

                    initFlowbite();
                }).fail(function(error) {

                }).always(function() {
                    $('.loader').css('display', 'none');

                })
            })
        })
    </script>
@endsection
