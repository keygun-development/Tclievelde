function toggleHamburger() {
    var x = document.getElementById("mobile-nav");
    if (x.style.height === "308px") {
        x.style.height = "0";
    } else {
        x.style.height = "308px";
    }
}

function toggleAccordion(element) {
    //Get clicked element parent.
    var parent = element.closest("div.specification__accordion");
    //Get the parent's panel
    var panel = parent.getElementsByClassName('specification__accordion-panel')[0];
    console.log(panel);
    //If panel has a height, toggle it. If not, give it the needed height.
    if (panel.style.maxHeight) {
        panel.style.marginBottom = null;
        panel.style.maxHeight = null;
        panel.style.overflow = "hidden";
    } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
        panel.style.marginBottom = "20px";
        panel.style.overflow = "visible";
    }
}

window.addEventListener('load', (event) => {
    let elements = document.getElementsByClassName("wp-block-eedee-block-gutenslider");
    for (let i = 0; i < elements.length; ++i) {
        let wrapper = document.createElement('div');

        elements[i].parentNode.insertBefore(wrapper, elements[i]);
        wrapper.appendChild(elements[i]);
    }
});
