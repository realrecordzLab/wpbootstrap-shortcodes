## Bootstrap shortcodes

This dirty and quick simple plugin will allow you to use the Bootstrap 4 grid system for your pages and posts content layout.
It's inspired by various page builders that under the hood will use the shortcode API of WordPress to style the contents of a post or a page. It will not provide a traditional drag & drop user interface like the other page builders but it's a very powerful tool if you have a bit of knowledge of the Bootstrap responsive grid system. 

**NB: Use it with the classic editor. Not tested with Gutemberg.**

## USAGE

Copy the plugin folder inside the wp-content/plugin directory of your WordPress installation then activate it. 

## Available shortcodes:

**bs-container**

This shortcode will output a container or a container-fluid. A row will be automatically added when you call it.
###### Shortcode params: 
* type: set the container type
* class: set a custom class for the choosed container
* id: set a custom id for the choosed container
###### Example:
```
[bs-container type="container-fluid" class="myclass" id="myid"][/bs-container]
```

**bs-col**

This shortcode will output a column. You can use all the available columns sizes provided by Bootstrap.
###### Shortcode params:
* type: set the desired column size
* class: set a custom class for the column
* id: set a custom id for the column
* mobile: choose if the column will be visible on small screen (col-sm- breakpoint). By default the visibility is set to display. Use hide if you want to hide a column on mobile.
###### Example:
```
[bs-col type="6" class="myclass" id="myid" mobile="hide" ][/bs-col]
```

**bs-modal**

This shortcode will output a Bootstrap modal popup. 
###### Shortcode params:
* class: set a custom class for the modal
* id: set a custom id for the modal
###### Example:
```
[bs-modal class="" id=""][/bs-modal]
```

**bs-parallax**

This shortcode will output a jumbotron component with a mobile friendly [parallax](https://github.com/marrio-h/universal-parallax) effect for the selected background image.
It can be used also as a section that will hold some contents of your post or page layout.  
###### Shortcode params:
* img: set the desired image to use as component background
* class: set a custom class for the component
* id: set a custom id for the component
* is_section: choose if the component will hold some button or text contents 
###### Example:
```
[bs-parallax img="https://yourimageurl.com" class="" id="" is_section="false"][/bs-parallax]
```

**bs-slider**

This shortcode will output a Swiper image slider. You can use all the attached images of a post or a page
Don't forget to initialize it from your theme javascript file. See the [Swiper](https://swiperjs.com/api/#initialize) docs for options and details.
###### Shortcode params:
* class: set a custom class for the slider
* id: set a custom id for the slider
###### Example:
```
[bs-slider class="" id=""][/bs-slider]
```
