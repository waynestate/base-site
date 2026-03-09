/*
 *   This content is licensed according to the W3C Software License at
 *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
 *
 *   Desc:   Adds sorting to a HTML data table that implements ARIA Authoring Practices
 *
 *
 */

'use strict';

class SortableTable {
    constructor(tableNode) {
        this.tableNode = tableNode;

        // Ensure there is a table caption and screen reader information about being sortable
        var tableCaption = tableNode.querySelector('caption');
        if (!tableCaption) {
            // If there is no caption, create one and add it to the table
            tableCaption = document.createElement('caption');
            tableNode.insertBefore(tableCaption, tableNode.firstChild);
        }

        // Add a screen reader only text to the caption to indicate that the table is sortable
        var srOnlyText = document.createElement('span');
        srOnlyText.classList.add('sr-only');
        srOnlyText.textContent = ' (column headers with buttons are sortable).';
        tableCaption.appendChild(srOnlyText);

        this.columnHeaders = tableNode.querySelectorAll('thead th');

        this.sortColumns = [];

        for (var i = 0; i < this.columnHeaders.length; i++) {
            var ch = this.columnHeaders[i];

            // If the column doesn't contain the 'no-sort' class, make it sortable
            if (ch.classList.contains('no-sort')) {
                continue;
            }

            // Create a button for the column header text and add it to the column header
            var chText = ch.textContent.trim();
            var buttonNode = document.createElement('button');
            buttonNode.textContent = chText;

            // Add an element to the button to indicate that it is sortable
            var sortIcon = document.createElement('span');
            sortIcon.setAttribute('aria-hidden', 'true');
            buttonNode.appendChild(sortIcon);

            // Store the column index in an array and as a data attribute on the button
            this.sortColumns.push(i);
            buttonNode.setAttribute('data-column-index', i);
            buttonNode.addEventListener('click', this.handleClick.bind(this));

            // Replace the column header text with the button
            ch.textContent = '';
            ch.appendChild(buttonNode);
        }

        this.tableNode.classList.add('show-unsorted-icon');
    }

    setColumnHeaderSort(columnIndex) {
        if (typeof columnIndex === 'string') {
            columnIndex = parseInt(columnIndex);
        }

        for (var i = 0; i < this.columnHeaders.length; i++) {
            var ch = this.columnHeaders[i];
            var buttonNode = ch.querySelector('button');
            if (i === columnIndex) {
                var value = ch.getAttribute('aria-sort');
                if (value === 'descending') {
                    ch.setAttribute('aria-sort', 'ascending');
                    this.sortColumn(
                        columnIndex,
                        'ascending',
                        ch.classList.contains('num')
                    );
                } else {
                    ch.setAttribute('aria-sort', 'descending');
                    this.sortColumn(
                        columnIndex,
                        'descending',
                        ch.classList.contains('num')
                    );
                }
            } else {
                if (ch.hasAttribute('aria-sort') && buttonNode) {
                    ch.removeAttribute('aria-sort');
                }
            }
        }
    }

    sortColumn(columnIndex, sortValue, isNumber) {
        function compareValues(a, b) {
            if (sortValue === 'ascending') {
                if (a.value === b.value) {
                    return 0;
                } else {
                    if (isNumber) {
                        return a.value - b.value;
                    } else {
                        return a.value < b.value ? -1 : 1;
                    }
                }
            } else {
                if (a.value === b.value) {
                    return 0;
                } else {
                    if (isNumber) {
                        return b.value - a.value;
                    } else {
                        return a.value > b.value ? -1 : 1;
                    }
                }
            }
        }

        if (typeof isNumber !== 'boolean') {
            isNumber = false;
        }

        var tbodyNode = this.tableNode.querySelector('tbody');
        var rowNodes = [];
        var dataCells = [];

        var rowNode = tbodyNode.firstElementChild;

        var index = 0;
        while (rowNode) {
            rowNodes.push(rowNode);
            var rowCells = rowNode.querySelectorAll('th, td');
            var dataCell = rowCells[columnIndex];

            var data = {};
            data.index = index;
            data.value = dataCell.textContent.toLowerCase().trim();
            if (isNumber) {
                data.value = parseFloat(data.value);
            }
            dataCells.push(data);
            rowNode = rowNode.nextElementSibling;
            index += 1;
        }

        dataCells.sort(compareValues);

        // remove rows
        while (tbodyNode.firstChild) {
            tbodyNode.removeChild(tbodyNode.lastChild);
        }

        // add sorted rows
        for (var i = 0; i < dataCells.length; i += 1) {
            tbodyNode.appendChild(rowNodes[dataCells[i].index]);
        }
    }

    /* EVENT HANDLERS */

    handleClick(event) {
        var tgt = event.currentTarget;
        this.setColumnHeaderSort(tgt.getAttribute('data-column-index'));
    }
}

// Initialize sortable table buttons
window.addEventListener('load', function () {
    var sortableTables = document.querySelectorAll('table.table-sort');
    for (var i = 0; i < sortableTables.length; i++) {
        new SortableTable(sortableTables[i]);
    }
});
