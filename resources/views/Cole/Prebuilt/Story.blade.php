
	<div class="m-t-20 form-group StoryContainer">        
        <div class="container">
            

            <div class="Story">
                <input type="text" id="Title" placeholder="Name your story..." value="{{ $Cole['Data']['Content']['Title'] or '' }}"/>
                <ul class="Tools">
                    <li>
                        <button>
                            <i class="zmdi zmdi-format-bold"></i>
                        </button>
                    </li>
                    <li>
                        <button>
                            <i class="zmdi zmdi-format-italic"></i>
                        </button>
                    </li>
                    <li>
                        <button>
                            <i class="zmdi zmdi-format-underlined"></i>
                        </button>
                    </li>
                    <li>
                        <button>
                            <i class="zmdi zmdi-text-format"></i>
                        </button>
                    </li>
                    <li>
                        <button>
                            <i class="zmdi zmdi-link"></i>
                        </button>
                    </li>
                    <li>
                        <button>
                            <i class="zmdi zmdi-image"></i>
                        </button>
                    </li>
                            
                </ul>
                <textarea id="Body" data-autoresize rows="10" placeholder="Write your story...">{{ $Cole['Data']['Content']['Body'] or '' }}</textarea>
                <p><small><a href="https://www.markdowntutorial.com/" target="_blank">How do I write Markdown?</a></small></p>
                <pre>{{print_r($Cole)}}</pre>
            </div>
        </div>
	</div>
