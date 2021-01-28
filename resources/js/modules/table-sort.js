function createSortableTable(tableGroup) {
    let table = tableGroup;
    let headerGroup = table.querySelector('thead');
    let headerRow = headerGroup.querySelector('tr');
    let headers = headerRow.querySelectorAll('th');
    let rowGroup = table.querySelector('tbody');
    let rows = rowGroup.querySelectorAll('tr');
    let captionElement = table.querySelector('caption');
    if(captionElement !== null) {
        var caption = captionElement.innerText;
    }

    let sortOrder = null;
    let sortDirection = -1;

    let liveRegion = tableGroup.querySelector('#liveRegion');
    if(liveRegion !== null) {
        liveRegion.classList.add('deque-visuallyhidden');
        liveRegion.notify = function (text) {
            liveRegion.innerHTML = text;
        };
    }

    function getSortDirection() {
        return sortDirection > 0 ? 'descending' : 'ascending';
    }

    function renderSorting() {
        updateAriaSort();
        if(captionElement !== null) {
            updateCaption();
        }
        if(captionElement !== null && liveRegion !== null) {
            updateLiveRegion();
        }
    }

    function updateAriaSort() {
        for (let i = 0; i < headerRow.children.length; i++) {
            let child = headerRow.children[i];

            if (sortOrder !== null && i === Math.abs(sortOrder)) {
                let direction = getSortDirection();
                child.setAttribute('aria-sort', direction);
                child.querySelector('.table-sort-image').innerHTML = (direction == 'descending' ? '\u25B2' : '\u25BC');
            } else {
                child.removeAttribute('aria-sort');
                child.querySelector('.table-sort-image').innerHTML = '\u25BC';
            }
        }
    }

    function updateCaption() {
        captionElement.innerText = caption + ' ' + getSortInfo();
    }

    function updateLiveRegion() {
        liveRegion.notify('Table ' + caption + ' is now ' + getSortInfo());
    }

    function getSortInfo() {
        if (sortOrder === null) {
            return 'unsorted';
        }

        return 'sorted by ' + getSortLabel() + ', ' + getSortDirection();
    }

    function getSortLabel() {
        let header = getSortHeader();
        if (!header) {
            return null;
        }
        return header.innerText;
    }

    function getSortHeader() {
        if (sortOrder === null) {
            return null;
        }

        return headerRow.children[sortOrder];
    }

    rows = Array.prototype.slice.call(rows);
    let isValid = rows.every(function (row) {
        return row.children.length === headers.length;
    });

    if (!isValid) {
        throw new Error('Each row must be the same length as the headers row.');
    }

    headers = Array.prototype.slice.call(headers);
    [].slice.call(headers).forEach(function (header, i) {
        createHeaderCell(header, function (e) {
            e.preventDefault();
            rows = sortByIndex(rows, i);
            table.renderData(rows);
        });
    });

    table.renderData = function (rows) {
        rowGroup.innerHTML = toHTML(rows);
        renderSorting();
    };

    table.renderData(rows);

    function sortByIndex(rows, index) {
        rows = tableGroup.querySelectorAll('tbody tr');
        rows = [].slice.call(rows);

        if (sortOrder === index) {
            sortDirection = -sortDirection;

            return rows.reverse();
        } else {
            sortOrder = index;

            return rows.sort(function (a, b) {
                a = Array.prototype.slice.call(a.children);
                b = Array.prototype.slice.call(b.children);
                let aVal = null;
                let bVal = null;

                if (a[index]) {
                    aVal = a[index].innerText;
                }

                if (b[index]) {
                    bVal = b[index].innerText;
                }

                if (!isNaN(parseInt(aVal)) && !isNaN(parseInt(bVal))) {
                    if (parseInt(aVal) < parseInt(bVal)) {
                        return -1;
                    }
                    if (parseInt(aVal) > parseInt(bVal)) {
                        return 1;
                    }

                    return 0;
                } else {
                    if (aVal < bVal) {
                        return -1;
                    }
                    if (aVal > bVal) {
                        return 1;
                    }

                    return 0;
                }
            });
        }
    }

    let firstOne = table.querySelector('.sortableColumnLabel');
    if (firstOne) {
        firstOne.click();
    }
}

function createHeaderCell(header, handler) {
    header.setAttribute('tabindex', '0');
    header.innerHTML = header.innerHTML + '<span class="table-sort-image" aria-hidden="true"></span>';

    header.addEventListener('click', handler);
}

function toHTML(rows) {
    return rows.map(function (row) {
        row = Array.prototype.slice.call(row.children);
        return '<tr role="row">\n    ' + row.map(function (item) {
            return '<td role="gridcell">' + item.innerText + '</td>';
        }).join('') + '</tr>';
    }).join('');
}

function activateAllSortableTables() {
    var sortableTables = document.querySelectorAll('.table-sort');
    for (var i = 0; i < sortableTables.length; i++) {
        createSortableTable(sortableTables[i]);
    }
}

activateAllSortableTables();
