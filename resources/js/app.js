import Alpine from "alpinejs";
import "./bootstrap";
import "./complaintmap";
import AOS from "aos";
import 'aos/dist/aos.css';

window.AOS = AOS;
window.Alpine = Alpine;

Alpine.start();
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    mirror: false
});