//
// Ajouter à element les classes séparées par un espace contenues dans cssClass
//
function addClass(element, cssClass) {
    if ((cssClass !== undefined) && (cssClass !== null)) {
        let css = cssClass.split(" ");
        css.forEach(item => {element.classList.add(item)});
    }
}

//
// <div id='elementId' class="cssClass"> </div>
//
function makeDiv(elementId, cssClass){
    let div = document.createElement('div');
    div.id = elementId;
    addClass(div, cssClass);
    return div;
}

//
// <label for="targetElementId" class="cssClass">text</label>
//
function makeLabelFor(targetElementId, text, cssClass){
    let label = document.createElement('label');
    label.htmlFor = targetElementId;
    label.textContent = text;
    addClass(label, cssClass);
    return label;
}

//
// <input type"text" name="name" id="name" placeholder="placeHolder class="cssClass" />
//
function makeTextBox(name, placeHolder, cssClass){
    let textBox = document.createElement('input');
    textBox.type ="text";
    textBox.name = name;
    textBox.id = name;
    textBox.placeholder = placeHolder;
    addClass(textBox, cssClass);
    return textBox;
}

//
// <input type"hidden" name="name" id="name"/>
//
function makeHidden(name, value){
    let hidden = document.createElement('input');
    hidden.type ="hidden";
    hidden.name = name;
    hidden.id = name;
    hidden.value = value;
    return hidden;
}

//
// <input type"password" name="name" id="name" placeholder="placeHolder class="cssClass" />
//
function makePasswordBox(name, placeHolder, cssClass){
    let textBox = document.createElement('input');
    textBox.type ="password";
    textBox.name = name;
    textBox.id = name;
    textBox.placeholder = placeHolder;
    addClass(textBox, cssClass);
    return textBox;
}

//
// <input type="radio" name="name" id="name_index" value="value" class="cssClass" />
//
function makeRadioButton(name, index, value, cssClass) {
    let radioButton = document.createElement('input');
    radioButton.type = "radio";
    radioButton.name = name;
    radioButton.value = value;
    radioButton.id = name + "_" + index;
    addClass(radioButton, cssClass);
    return radioButton;
}

//
// <legend class="cssClass"> text </legend>
//
function makeLegend(text, cssClass){
    let legend = document.createElement('legend');
    legend.textContent = text;
    addClass(legend, cssClass);
    return legend;
}

//
// <div id="nameGroup" class="groupBox">
//      <fieldset>
//          <legend class="groupBoxLegend">title<legend/>
//          <input type="radio" name="name" id="name_0" value="radioButtonValues[0]" class="check-box" />
//          <label for="name_0" class="cssClass">radioButtonValues[0]</label>
//          <input type="radio" name="name" id="name_1" value="radioButtonValues[1]" class="check-box" />
//          <label for="name_1" class="cssClass">radioButtonValues[1]</label>
//          . . .
//      <fieldset
//  </div>
//
function makeRadioButtonsGroup(title, name, radioButtonValues) {
    let groupBox = makeDiv(name + "Group", "groupBox");
    let fieldset =  document.createElement('fieldset');
    groupBox.appendChild(fieldset);
    fieldset.appendChild(makeLegend(title,"groupBoxLegend"));
    for(let index in radioButtonValues)
    {
        let radioButton = makeRadioButton(name, index, radioButtonValues[index], "check-box");
        // Lorsqu'un bouton radio est changé transmettre l'événement au groupe
        radioButton.addEventListener("change",(e) => {
            let event = new Event('change');
            groupBox.dispatchEvent(event);
        });
        fieldset.appendChild(radioButton);
        fieldset.appendChild(makeLabelFor(radioButton.id, radioButtonValues[index], "radioButtonLabel"));
    }
    return groupBox;
}

//
// <option value="value">value</option>
//
function makeOption(value){
    let option = document.createElement("option");
    option.value = value;
    option.textContent = value;
    return option;
}

//
// <option value="" disabled selected>placeHolder</option>
//
function makeOptionPlaceHolder(placeHolder) {
    let option = document.createElement("option");
    option.value = "";
    option.textContent = placeHolder;
    option.disabled = true;
    option.selected = true;
    return option;
}

//
// <select name="name" id ="name" class="cssClass">
//      <option value="" disabled selected>placeHolder</option>
//      <option value="values[0]">values[0]</option>
//      <option value="values[1]">values[1]</option>
//      . . .
// </select>
//
function makeComboBox(name, values, placeHolder, cssClass){
    let comboBox = document.createElement('select');
    comboBox.name = name;
    comboBox.id = name;
    addClass(comboBox, cssClass);
    comboBox.appendChild(makeOptionPlaceHolder(placeHolder));
    values.forEach(value => { comboBox.appendChild(makeOption(value)); });
    return comboBox;
}

//<div>
// <input type="checkbox" name="Shared" id="Shared" class="">
//<label for="Shared">&nbsp;Partagée</label>
//</div>

function makeCheckBox(name, labelText, labelCssClass){
    let div = makeDiv('div_' + name);
    let checkbox = document.createElement('input');
    checkbox.type = "checkbox";
    checkbox.id = name;
    checkbox.name = name;

    div.appendChild(checkbox);

    let span = document.createElement('span');
    span.innerText=' ';
    div.appendChild(span);

    div.appendChild(makeLabelFor(name, labelText, labelCssClass));
    return div;
}
//
// <form id="name" name="name" acton="url" method="post"> </form>
//
function makeForm(name, url){
    let form =  document.createElement('form');
    form.method = "post";
    form.name= name;
    form.id = name;
    form.action = url;
    return form;
}

//
// <input type="submit" value="title" class="cssClass" />
//
function makeSubmitButton(title, cssClass){
    let submitButton = document.createElement("input");
    submitButton.type="submit";
    submitButton.value = title;
    addClass(submitButton, cssClass);
    return submitButton;
}
