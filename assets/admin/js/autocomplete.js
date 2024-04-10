import AutoComplete from "@tarekraafat/autocomplete.js";

const createNewSpan = (id, value, hiddenField) => {
    let element = document.createElement('span');
    let txt = document.createTextNode(value);
    let closeBtn = document.createElement('span');
    let icon = document.createElement('i');
    icon.setAttribute('class', 'ti ti-x')
    closeBtn.setAttribute('data-role', 'remove');
    closeBtn.append(icon);

    closeBtn.addEventListener('click', function (event) {
        const tag = event.target.closest('.badge');
        const id = tag.dataset.id;

        tag.remove();
        removeTag(hiddenField, id);
    });

    element.setAttribute('class', 'badge bg-primary')
    element.setAttribute('data-id', id)
    element.append(txt);
    element.append(closeBtn);

    return element;
}

const updateHiddenField = (field, tmpField, id, value) => {
    const ids = field.value ? field.value.split(',') : [];
    const values = tmpField.value ? tmpField.value.split(',') : [];

    ids.push(id);
    values.push(value);

    field.value = ids.join();
    tmpField.value = values.join();
}

const removeTag = (field, id) => {
    const values = field.value ? field.value.split(',') : [];
    values.splice(values.indexOf(id.toString()), 1);

    field.value = values.join();
}

const iNewValue = (field, value) => {
    const values = field.value ? field.value.split(',') : [];

    return !values.includes(value.id.toString())
}

const tmpField = (elt) => {
    const wrapper = elt.parentNode
    const tempElt = document.createElement('input')
    tempElt.setAttribute('type', 'hidden')
    tempElt.setAttribute('name', 'tmp_value')

    if (!tempElt.value) {
        tempElt.value = elt.value
    }

    console.error('fako');
    wrapper.append(tempElt);
}

const initField = (elt) => {
    const wrapper = elt.parentNode
    const container = wrapper.closest('.autocomplete-container')
    const hiddenField = container.querySelector('.id-values[type="hidden"]')
    const tmpField = container.querySelector('.tmp-values[type="hidden"]')

    if (tmpField && tmpField.value) {
        const values = tmpField && tmpField.value.split(',')
        const ids = hiddenField.value.split(',')

        values.forEach((val, index) => {
            createNewSpan(ids[index], val, hiddenField)
            const element = createNewSpan(ids[index], val, hiddenField)
            wrapper.insertBefore(element, elt);
        })
    }

    elt.value = '';
}

document.querySelectorAll('.js-multi-autocomplete').forEach((elt) => {

    const config = {
        selector: () => elt,
        data: {
            src: async (query) => {
                try {
                    const source = await fetch(elt.dataset.api + '?query='+ query);
                    return await source.json();

                } catch (error) {
                    return error;
                }
            },
            keys: [elt.dataset.key],
        },
        query: (query) => {
            const querySplit = query.split(","); // Split query into array
            const lastQuery = querySplit.length - 1; // Get last query value index
            return querySplit[lastQuery].trim(); // Trim new query
        },
        resultsList: {
            element: (list, data) => {
                if (!data.results.length) {
                    // Create "No Results" message element
                    const message = document.createElement("div");
                    // Add class to the created element
                    message.setAttribute("class", "no_result");
                    // Add message text content
                    message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                    // Append message element to the results list
                    list.prepend(message);
                }
            },
            noResults: true,
        },
        resultItem: {
            highlight: true,
        },
        events: {
            input: {
                selection: (event) => {
                    const feedback = event.detail;
                    const input = autoCompleteJS.input;
                    const wrapper = input.parentNode;
                    const selection = feedback.selection.value[feedback.selection.key].trim(); // Trim selected Value
                    const query = input.value.split(",").map(item => item.trim()); // Split query into array and trim each value

                    query.pop(); // Remove last query
                    query.push(selection); // Add selected value

                    // Clear input
                    input.value = '';

                    // Update hidden field
                    const container = wrapper.closest('.autocomplete-container');
                    const hiddenField = container.querySelector('.id-values[type="hidden"]')
                    const tmpField = container.querySelector('.tmp-values[type="hidden"]')

                    if (iNewValue(hiddenField, feedback.selection.value)) {
                        updateHiddenField(hiddenField, tmpField, feedback.selection.value.id, selection);

                        const element = createNewSpan(feedback.selection.value.id, selection, hiddenField)
                        wrapper.insertBefore(element, input);
                    }
                }
            }
        }
    }

    const autoCompleteJS = new AutoComplete(config);

    initField(elt);
})

