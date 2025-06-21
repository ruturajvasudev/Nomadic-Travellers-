<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Travel Blog Front Page</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap');

  body, html {
    margin: 0; padding: 0;
    font-family: 'Arial', sans-serif;
    background: #f3e7e6;
    color: #fff;
  }
  .cnt {
    display: flex;
    min-height: 100vh;
    background: url('../imgs/hotair.jpg') center/cover no-repeat;

  }
  .left {
    position: relative;
    flex: 1;
    padding: 3rem 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  /* White floral line-art design with CSS */
  .left::before, .left::after {
    content: "";
    position: absolute;
    border: 2px solid white;
    border-radius: 50%;
    opacity: 0.15;
    pointer-events: none;
  }
  .left::before {
    width: 220px;
    height: 220px;
    top: 30px;
    left: 30px;
    border-style: dashed;
  }
  .left::after {
    width: 150px;
    height: 150px;
    bottom: 40px;
    left: 50px;
    border-style: solid;
  }

  .welcome-text {
    font-family: 'Dancing Script', cursive;
    font-weight: 400;
    font-size: 5rem;
    line-height: 1.1;
    color: white;
    letter-spacing: 0.03em;
    margin: 0 0 1rem 0;
    opacity: 0.9;
  }
  .normal-text {
    font-size: 1.2rem;
    color: white;
    max-width: 350px;
    margin-bottom: 2rem;
  }
  .explore-btn {
    background: white;
    color: #333;
    border: none;
    padding: 0.75rem 2rem;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 3px;
    cursor: pointer;
    width: fit-content;
    transition: background-color 0.3s ease;
  }
  .explore-btn:hover {
    background: #ddd;
  }

  .right {
    flex: 1;
    position: relative;
    
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
  }
  .slideshow {
    width: 300px;
    height: 400px;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0,0,0,0.15);
    position: relative;
  }
  .slide {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0; left: 0;
    opacity: 0;
    transition: opacity 1.5s ease-in-out;
    background-size: cover;
    background-position: center;
  }
  .slide.active {
    opacity: 1;
    position: relative;
  }

  @media (max-width: 768px) {
    .cnt {
      flex-direction: column;
    }
    .left, .right {
      flex: none;
      width: 100%;
      min-height: 50vh;
    }
    .welcome-text {
      font-size: 3rem;
    }
    .slideshow {
      width: 90%;
      height: 250px;
    }
  }
</style>
</head>
<body>

<div class="cnt">
  <section class="left">
    <h1 class="welcome-text">Welcome to</h1>
    <p class="normal-text">
      An award-winning solo female travel blog featuring travel tips, packing guides, videos and photography from around the world.
    </p>
    <button class="explore-btn">Explore</button>
  </section>

  <section class="right">
    <div class="slideshow" aria-label="Travel photos slideshow">
    <div class="slide " style="background-image: url('../imgs/ha_3.jpg');"></div>
    <div class="slide " style="background-image: url('../imgs/ha_2.jpg');"></div>
    <div class="slide " style="background-image: url('../imgs/s2.jpg');"></div>
    <div class="slide " style="background-image: url('../imgs/s3.jpg');"></div>
    <div class="slide " style="background-image: url('../imgs/s4.jpg');"></div>
    <div class="slide " style="background-image: url('../imgs/s5.jpg');"></div>
    <div class="slide " style="background-image: url('../imgs/s6.jpg');"></div>


      <div class="slide" style="background-image: url('../imgs/mtn.jpg');"></div>

      <div class="slide">
  <video class="video-slide" autoplay muted loop playsinline>
    <source src="../imgs/nature_vdo.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>
</div>
    </div>
  </section>
</div>

<script>
  // Simple slideshow auto fade
  const slides = document.querySelectorAll('.slide');
  let current = 0;

  function nextSlide() {
    slides[current].classList.remove('active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
  }

  setInterval(nextSlide, 4000);
</script>

</body>
</html>
