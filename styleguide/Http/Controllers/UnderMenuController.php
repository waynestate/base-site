<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnderMenuController extends Controller
{
    /**
     * Display each under menu button option.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $icon_light = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNNTAgMi41QzIzLjggMi41IDIuNSAyMy44IDIuNSA1MFMyMy44IDk3LjUgNTAgOTcuNSA5Ny41IDc2LjIgOTcuNSA1MCA3Ni4yIDIuNSA1MCAyLjV6bS02LjIgMTguNGMxLjYtMS41IDMuNS0yLjIgNS42LTIuMiAyLjIgMCA0LjEuNyA1LjYgMi4yIDEuNiAxLjUgMi4zIDMuMiAyLjMgNS4zIDAgMi0uOCAzLjgtMi40IDUuMi0xLjYgMS40LTMuNCAyLjItNS42IDIuMi0yLjIgMC00LjEtLjctNS42LTIuMi0xLjYtMS40LTIuNC0zLjItMi40LTUuMi4xLTIuMS45LTMuOSAyLjUtNS4zem0xOS41IDYwLjRIMzcuN3YtM2MuNy0uMSAxLjQtLjEgMi4xLS4yczEuMy0uMiAxLjctLjRjLjktLjMgMS41LS44IDEuOC0xLjQuMy0uNi41LTEuNC41LTIuNFY1MC40YzAtLjktLjItMS44LS42LTIuNS0uNC0uNy0xLTEuMy0xLjYtMS43LS41LS4zLTEuMi0uNi0yLjItLjlzLTEuOS0uNS0yLjctLjZ2LTNsMTkuOC0xLjEuNi42djMyLjFjMCAuOS4yIDEuNy42IDIuNC40LjcgMSAxLjIgMS43IDEuNS41LjIgMS4xLjUgMS44LjYuNi4yIDEuMy4zIDIgLjR2My4xeiIvPjwvc3ZnPg==";
        $icon_dark = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNNTAgMi41QzIzLjggMi41IDIuNSAyMy44IDIuNSA1MFMyMy44IDk3LjUgNTAgOTcuNSA5Ny41IDc2LjIgOTcuNSA1MCA3Ni4yIDIuNSA1MCAyLjV6bS02LjIgMTguNGMxLjYtMS41IDMuNS0yLjIgNS42LTIuMiAyLjIgMCA0LjEuNyA1LjYgMi4yIDEuNiAxLjUgMi4zIDMuMiAyLjMgNS4zIDAgMi0uOCAzLjgtMi40IDUuMi0xLjYgMS40LTMuNCAyLjItNS42IDIuMi0yLjIgMC00LjEtLjctNS42LTIuMi0xLjYtMS40LTIuNC0zLjItMi40LTUuMi4xLTIuMS45LTMuOSAyLjUtNS4zem0xOS41IDYwLjRIMzcuN3YtM2MuNy0uMSAxLjQtLjEgMi4xLS4yczEuMy0uMiAxLjctLjRjLjktLjMgMS41LS44IDEuOC0xLjQuMy0uNi41LTEuNC41LTIuNFY1MC40YzAtLjktLjItMS44LS42LTIuNS0uNC0uNy0xLTEuMy0xLjYtMS43LS41LS4zLTEuMi0uNi0yLjItLjlzLTEuOS0uNS0yLjctLjZ2LTNsMTkuOC0xLjEuNi42djMyLjFjMCAuOS4yIDEuNy42IDIuNC40LjcgMSAxLjIgMS43IDEuNS41LjIgMS4xLjUgMS44LjYuNi4yIDEuMy4zIDIgLjR2My4xeiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==";
        $bg_light = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMzYwIDEzMSI+PHBhdHRlcm4gd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIiBpZD0iYSIgdmlld0JveD0iMCAtODAgODAgODAiIG92ZXJmbG93PSJ2aXNpYmxlIj48cGF0aCBmaWxsPSJub25lIiBkPSJNMC04MGg4MFYwSDB6Ii8+PHBhdGggZD0iTTAtNDBoNDB2LTQwSDB2NDB6TTQwIDBoNDB2LTQwSDQwVjB6bTAtNzhsMi0yaC0ydjJ6bTAgNGw2LTZoLTJsLTQgNHYyem0wIDRsMTAtMTBoLTJsLTggOHYyem0wIDRsMTQtMTRoLTJMNDAtNjh2MnptMCA0bDE4LTE4aC0yTDQwLTY0djJ6bTAgNGwyMi0yMmgtMkw0MC02MHYyem0wIDRsMjYtMjZoLTJMNDAtNTZ2MnptMCA0bDMwLTMwaC0yTDQwLTUydjJ6bTAgNGwzNC0zNGgtMkw0MC00OHYyem0wIDRsMzgtMzhoLTJMNDAtNDR2MnptMiAybDM4LTM4di0yTDQwLTQwaDJ6bTQgMGwzNC0zNHYtMkw0NC00MGgyem00IDBsMzAtMzB2LTJMNDgtNDBoMnptNCAwbDI2LTI2di0yTDUyLTQwaDJ6bTQgMGwyMi0yMnYtMkw1Ni00MGgyem00IDBsMTgtMTh2LTJMNjAtNDBoMnptNCAwbDE0LTE0di0yTDY0LTQwaDJ6bTQgMGwxMC0xMHYtMkw2OC00MGgyem00IDBsNi02di0ybC04IDhoMnptNCAwbDItMnYtMmwtNCA0aDJ6IiBmaWxsPSIjZmZmMGM4Ii8+PC9wYXR0ZXJuPjxwYXRoIGZpbGw9IiNmZmNkMzQiIGQ9Ik0wIDBoMzYwdjEzMUgweiIvPjxwYXR0ZXJuIGlkPSJiIiB4bGluazpocmVmPSIjYSIgcGF0dGVyblRyYW5zZm9ybT0idHJhbnNsYXRlKDc3LjYzOCA2Ni41OSkgc2NhbGUoMS4wMDgzKSIvPjxwYXRoIGZpbGw9InVybCgjYikiIGQ9Ik0wIDBoMzYwdjEzMUgweiIvPjwvc3ZnPg==";
        $bg_dark = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMzYwIDEzMSI+PHBhdHRlcm4gd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIiBpZD0iYSIgdmlld0JveD0iMCAtODAgODAgODAiIG92ZXJmbG93PSJ2aXNpYmxlIj48cGF0aCBmaWxsPSJub25lIiBkPSJNMC04MGg4MFYwSDB6Ii8+PHBhdGggZD0iTTAtNDBoNDB2LTQwSDB2NDB6TTQwIDBoNDB2LTQwSDQwVjB6bTAtNzhsMi0yaC0ydjJ6bTAgNGw2LTZoLTJsLTQgNHYyem0wIDRsMTAtMTBoLTJsLTggOHYyem0wIDRsMTQtMTRoLTJMNDAtNjh2MnptMCA0bDE4LTE4aC0yTDQwLTY0djJ6bTAgNGwyMi0yMmgtMkw0MC02MHYyem0wIDRsMjYtMjZoLTJMNDAtNTZ2MnptMCA0bDMwLTMwaC0yTDQwLTUydjJ6bTAgNGwzNC0zNGgtMkw0MC00OHYyem0wIDRsMzgtMzhoLTJMNDAtNDR2MnptMiAybDM4LTM4di0yTDQwLTQwaDJ6bTQgMGwzNC0zNHYtMkw0NC00MGgyem00IDBsMzAtMzB2LTJMNDgtNDBoMnptNCAwbDI2LTI2di0yTDUyLTQwaDJ6bTQgMGwyMi0yMnYtMkw1Ni00MGgyem00IDBsMTgtMTh2LTJMNjAtNDBoMnptNCAwbDE0LTE0di0yTDY0LTQwaDJ6bTQgMGwxMC0xMHYtMkw2OC00MGgyem00IDBsNi02di0ybC04IDhoMnptNCAwbDItMnYtMmwtNCA0aDJ6IiBmaWxsPSIjMDYyZTI5Ii8+PC9wYXR0ZXJuPjxwYXRoIGZpbGw9IiMwZTU0NGEiIGQ9Ik0wIDBoMzYwdjEzMUgweiIvPjxwYXR0ZXJuIGlkPSJiIiB4bGluazpocmVmPSIjYSIgcGF0dGVyblRyYW5zZm9ybT0idHJhbnNsYXRlKDc3LjYzOCA2Ni41OSkgc2NhbGUoMS4wMDgzKSIvPjxwYXRoIGZpbGw9InVybCgjYikiIGQ9Ik0wIDBoMzYwdjEzMUgweiIvPjwvc3ZnPg==";
        $svg_light = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNjAgMTMxIj48cGF0aCBkPSJNMTI3LjcgOTFoMTcuMnY1LjFoLTExLjZ2NC43aDExdjUuMWgtMTF2NS4xaDEyLjJ2NS4xaC0xNy44Vjkxek0xNTQgMTA3bC01LjgtOC4xaDYuM2wzLjEgNC43IDMtNC43aDZMMTYxIDEwN2w2LjcgOS4zaC02LjNsLTMuOC01LjgtNC4xIDUuOGgtNi4ybDYuNy05LjN6TTE4MCAxMTQuMWMtLjcuOS0xLjUgMS42LTIuNCAyLTEgLjQtMiAuNi0zLjEuNi0uOCAwLTEuNi0uMS0yLjMtLjMtLjctLjItMS40LS42LTItMS0uNi0uNS0xLTEtMS40LTEuNy0uMy0uNy0uNS0xLjQtLjUtMi4zIDAtMSAuMi0xLjguNi0yLjUuNC0uNy45LTEuMyAxLjUtMS43LjYtLjUgMS4zLS44IDIuMi0xLjEuOC0uMiAxLjYtLjQgMi41LS42LjktLjEgMS43LS4yIDIuNi0uMmgyLjRjMC0xLS4zLTEuNy0xLTIuMy0uNy0uNi0xLjUtLjgtMi40LS44LS45IDAtMS43LjItMi40LjYtLjcuNC0xLjQuOS0xLjkgMS41bC0yLjktMi45YzEtLjkgMi4yLTEuNiAzLjUtMi4xIDEuMy0uNSAyLjctLjcgNC4xLS43IDEuNiAwIDIuOS4yIDMuOS42IDEgLjQgMS44IDEgMi40IDEuNy42LjggMSAxLjcgMS4zIDIuOC4yIDEuMS40IDIuNC40IDMuOHY4LjhIMTgwdi0yLjJ6bS0xLjMtNS40Yy0uNCAwLS45IDAtMS41LjEtLjYgMC0xLjIuMS0xLjcuMy0uNi4yLTEgLjQtMS40LjctLjQuMy0uNi44LS42IDEuNCAwIC42LjMgMS4xLjggMS40LjUuMyAxLjEuNSAxLjcuNS41IDAgMS0uMSAxLjUtLjJzLjktLjMgMS4zLS42LjctLjYuOS0xYy4yLS40LjMtLjkuMy0xLjR2LTEuMWgtMS4zek0xODguMyA5OC45aDUuMXYyLjRoLjFjLjItLjMuNC0uNy43LTFzLjctLjYgMS4xLS45Yy40LS4zLjktLjUgMS41LS42LjUtLjIgMS4xLS4yIDEuOC0uMiAxLjIgMCAyLjMuMiAzLjIuNy45LjUgMS42IDEuMyAyLjEgMi40LjYtMS4xIDEuNC0xLjkgMi4yLTIuNC45LS41IDItLjcgMy4yLS43IDEuMiAwIDIuMS4yIDIuOS42czEuNC45IDEuOSAxLjZjLjUuNy44IDEuNSAxIDIuNC4yLjkuMyAxLjkuMyAyLjl2MTAuMkgyMTB2LTEwLjFjMC0uOC0uMi0xLjUtLjUtMi4xcy0xLS45LTEuOC0uOWMtLjYgMC0xLjEuMS0xLjYuMy0uNC4yLS43LjUtMSAuOC0uMi40LS40LjgtLjUgMS4yLS4xLjUtLjIgMS0uMiAxLjV2OS4ySDE5OVYxMDd2LTEuMWMwLS41LS4xLS45LS4yLTEuM3MtLjQtLjctLjctMWMtLjMtLjMtLjgtLjQtMS40LS40LS43IDAtMS4yLjEtMS43LjQtLjQuMi0uOC42LTEgMS0uMi40LS40LjktLjQgMS40LS4xLjUtLjEgMS4xLS4xIDEuNnY4LjZoLTUuNFY5OC45ek0yMTkuOSA5OC45aDQuOXYyLjNoLjFjLjItLjMuNS0uNi44LS45cy44LS42IDEuMi0uOWMuNS0uMyAxLS41IDEuNS0uNi41LS4yIDEuMS0uMiAxLjctLjIgMS4zIDAgMi40LjIgMy41LjcgMSAuNCAxLjkgMS4xIDIuNyAxLjlzMS4zIDEuNyAxLjcgMi44Yy40IDEuMS42IDIuMy42IDMuNiAwIDEuMi0uMiAyLjQtLjYgMy41LS40IDEuMS0uOSAyLjEtMS42IDIuOS0uNy45LTEuNSAxLjUtMi41IDIuMS0xIC41LTIuMS44LTMuMy44LTEuMSAwLTIuMi0uMi0zLjEtLjUtMS0uMy0xLjgtLjktMi40LTEuOGgtLjF2MTBoLTUuNFY5OC45em00LjkgOC43YzAgMS4zLjQgMi40IDEuMSAzLjIuNy44IDEuOCAxLjIgMy4yIDEuMiAxLjQgMCAyLjQtLjQgMy4yLTEuMi43LS44IDEuMS0xLjkgMS4xLTMuMiAwLTEuMy0uNC0yLjQtMS4xLTMuMi0uOC0uOC0xLjgtMS4yLTMuMi0xLjItMS40IDAtMi40LjQtMy4yIDEuMi0uOC44LTEuMSAxLjktMS4xIDMuMnpNMjQxLjkgODkuM2g1LjR2MjdoLTUuNHYtMjd6TTI2Ny41IDExMy4zYy0uOSAxLjEtMS45IDEuOS0zLjIgMi41LTEuMy42LTIuNy45LTQuMS45LTEuMyAwLTIuNi0uMi0zLjgtLjYtMS4yLS40LTIuMi0xLTMuMS0xLjgtLjktLjgtMS42LTEuOC0yLjEtMi45LS41LTEuMS0uNy0yLjQtLjctMy43IDAtMS40LjItMi42LjctMy43LjUtMS4xIDEuMi0yLjEgMi4xLTIuOS45LS44IDEuOS0xLjQgMy4xLTEuOCAxLjItLjQgMi40LS42IDMuOC0uNiAxLjIgMCAyLjQuMiAzLjQuNiAxIC40IDEuOSAxIDIuNiAxLjguNy44IDEuMiAxLjggMS42IDIuOS40IDEuMS42IDIuNC42IDMuN3YxLjdIMjU2Yy4yIDEgLjcgMS44IDEuNCAyLjQuNy42IDEuNi45IDIuNi45LjkgMCAxLjYtLjIgMi4yLS42czEuMS0uOSAxLjYtMS41bDMuNyAyLjd6bS00LjUtNy43YzAtLjktLjMtMS43LS45LTIuMy0uNi0uNi0xLjQtMS0yLjQtMS0uNiAwLTEuMS4xLTEuNi4zLS41LjItLjguNC0xLjIuNy0uMy4zLS42LjYtLjcgMS0uMi40LS4zLjgtLjMgMS4yaDcuMXpNMjkzLjkgMTAzLjJoLTQuN3Y1LjhjMCAuNSAwIC45LjEgMS4zIDAgLjQuMi43LjMgMSAuMi4zLjQuNS44LjcuMy4yLjguMiAxLjQuMi4zIDAgLjcgMCAxLjEtLjEuNS0uMS44LS4yIDEuMS0uNHY0LjVjLS42LjItMS4yLjQtMS45LjQtLjYuMS0xLjMuMS0xLjkuMS0uOSAwLTEuNy0uMS0yLjUtLjMtLjgtLjItMS40LS41LTItLjktLjYtLjQtMS0xLTEuMy0xLjYtLjMtLjctLjUtMS41LS41LTIuNHYtOC4yaC0zLjRWOTloMy40di01LjFoNS40Vjk5aDQuN3Y0LjJ6TTMxMy4xIDExMy4zYy0uOSAxLjEtMS45IDEuOS0zLjIgMi41LTEuMy42LTIuNy45LTQuMS45LTEuMyAwLTIuNi0uMi0zLjgtLjYtMS4yLS40LTIuMi0xLTMuMS0xLjgtLjktLjgtMS42LTEuOC0yLjEtMi45LS41LTEuMS0uNy0yLjQtLjctMy43IDAtMS40LjItMi42LjctMy43LjUtMS4xIDEuMi0yLjEgMi4xLTIuOS45LS44IDEuOS0xLjQgMy4xLTEuOCAxLjItLjQgMi40LS42IDMuOC0uNiAxLjIgMCAyLjQuMiAzLjQuNiAxIC40IDEuOSAxIDIuNiAxLjguNy44IDEuMiAxLjggMS42IDIuOS40IDEuMS42IDIuNC42IDMuN3YxLjdoLTEyLjRjLjIgMSAuNyAxLjggMS40IDIuNC43LjYgMS42LjkgMi42LjkuOSAwIDEuNi0uMiAyLjItLjZzMS4xLS45IDEuNi0xLjVsMy43IDIuN3ptLTQuNi03LjdjMC0uOS0uMy0xLjctLjktMi4zLS42LS42LTEuNC0xLTIuNC0xLS42IDAtMS4xLjEtMS42LjMtLjUuMi0uOC40LTEuMi43LS4zLjMtLjYuNi0uNyAxLS4yLjQtLjMuOC0uMyAxLjJoNy4xek0zMjEuOCAxMDdsLTUuOC04LjFoNi4zbDMuMSA0LjcgMy00LjdoNmwtNS42IDguMSA2LjcgOS4zSDMyOWwtMy44LTUuOC00LjEgNS44SDMxNWw2LjgtOS4zek0zNDguOCAxMDMuMmgtNC43djUuOGMwIC41IDAgLjkuMSAxLjMgMCAuNC4yLjcuMyAxIC4yLjMuNC41LjguNy4zLjIuOC4yIDEuNC4yLjMgMCAuNyAwIDEuMS0uMS41LS4xLjgtLjIgMS4xLS40djQuNWMtLjYuMi0xLjIuNC0xLjkuNC0uNi4xLTEuMy4xLTEuOS4xLS45IDAtMS43LS4xLTIuNS0uMy0uOC0uMi0xLjQtLjUtMi0uOS0uNi0uNC0xLTEtMS4zLTEuNi0uMy0uNy0uNS0xLjUtLjUtMi40di04LjJoLTMuNFY5OWgzLjR2LTUuMWg1LjRWOTloNC43djQuMnoiLz48L3N2Zz4=";
        $svg_dark = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNjAgMTMxIj48cGF0aCBkPSJNMTI3LjcgOTFoMTcuMnY1LjFoLTExLjZ2NC43aDExdjUuMWgtMTF2NS4xaDEyLjJ2NS4xaC0xNy44Vjkxem0yNi4zIDE2bC01LjgtOC4xaDYuM2wzLjEgNC43IDMtNC43aDZMMTYxIDEwN2w2LjcgOS4zaC02LjNsLTMuOC01LjgtNC4xIDUuOGgtNi4ybDYuNy05LjN6bTI2IDcuMWMtLjcuOS0xLjUgMS42LTIuNCAyLTEgLjQtMiAuNi0zLjEuNi0uOCAwLTEuNi0uMS0yLjMtLjMtLjctLjItMS40LS42LTItMS0uNi0uNS0xLTEtMS40LTEuNy0uMy0uNy0uNS0xLjQtLjUtMi4zIDAtMSAuMi0xLjguNi0yLjUuNC0uNy45LTEuMyAxLjUtMS43LjYtLjUgMS4zLS44IDIuMi0xLjEuOC0uMiAxLjYtLjQgMi41LS42LjktLjEgMS43LS4yIDIuNi0uMmgyLjRjMC0xLS4zLTEuNy0xLTIuMy0uNy0uNi0xLjUtLjgtMi40LS44cy0xLjcuMi0yLjQuNi0xLjQuOS0xLjkgMS41bC0yLjktMi45YzEtLjkgMi4yLTEuNiAzLjUtMi4xczIuNy0uNyA0LjEtLjdjMS42IDAgMi45LjIgMy45LjZzMS44IDEgMi40IDEuN2MuNi44IDEgMS43IDEuMyAyLjguMiAxLjEuNCAyLjQuNCAzLjh2OC44SDE4MHYtMi4yem0tMS4zLTUuNGMtLjQgMC0uOSAwLTEuNS4xLS42IDAtMS4yLjEtMS43LjMtLjYuMi0xIC40LTEuNC43LS40LjMtLjYuOC0uNiAxLjRzLjMgMS4xLjggMS40IDEuMS41IDEuNy41Yy41IDAgMS0uMSAxLjUtLjJzLjktLjMgMS4zLS42LjctLjYuOS0xIC4zLS45LjMtMS40di0xLjFoLTEuM3YtLjF6bTkuNi05LjhoNS4xdjIuNGguMWMuMi0uMy40LS43LjctMXMuNy0uNiAxLjEtLjljLjQtLjMuOS0uNSAxLjUtLjYuNS0uMiAxLjEtLjIgMS44LS4yIDEuMiAwIDIuMy4yIDMuMi43czEuNiAxLjMgMi4xIDIuNGMuNi0xLjEgMS40LTEuOSAyLjItMi40LjktLjUgMi0uNyAzLjItLjdzMi4xLjIgMi45LjYgMS40LjkgMS45IDEuNi44IDEuNSAxIDIuNC4zIDEuOS4zIDIuOXYxMC4ySDIxMHYtMTAuMWMwLS44LS4yLTEuNS0uNS0yLjFzLTEtLjktMS44LS45Yy0uNiAwLTEuMS4xLTEuNi4zLS40LjItLjcuNS0xIC44LS4yLjQtLjQuOC0uNSAxLjItLjEuNS0uMiAxLS4yIDEuNXY5LjJIMTk5VjEwNS45YzAtLjUtLjEtLjktLjItMS4zcy0uNC0uNy0uNy0xLS44LS40LTEuNC0uNGMtLjcgMC0xLjIuMS0xLjcuNC0uNC4yLS44LjYtMSAxcy0uNC45LS40IDEuNGMtLjEuNS0uMSAxLjEtLjEgMS42djguNmgtNS40Vjk4LjloLjJ6bTMxLjYgMGg0Ljl2Mi4zaC4xYy4yLS4zLjUtLjYuOC0uOXMuOC0uNiAxLjItLjljLjUtLjMgMS0uNSAxLjUtLjYuNS0uMiAxLjEtLjIgMS43LS4yIDEuMyAwIDIuNC4yIDMuNS43IDEgLjQgMS45IDEuMSAyLjcgMS45czEuMyAxLjcgMS43IDIuOGMuNCAxLjEuNiAyLjMuNiAzLjYgMCAxLjItLjIgMi40LS42IDMuNS0uNCAxLjEtLjkgMi4xLTEuNiAyLjktLjcuOS0xLjUgMS41LTIuNSAyLjEtMSAuNS0yLjEuOC0zLjMuOC0xLjEgMC0yLjItLjItMy4xLS41LTEtLjMtMS44LS45LTIuNC0xLjhoLS4xdjEwaC01LjRWOTguOWguM3ptNC45IDguN2MwIDEuMy40IDIuNCAxLjEgMy4yLjcuOCAxLjggMS4yIDMuMiAxLjJzMi40LS40IDMuMi0xLjJjLjctLjggMS4xLTEuOSAxLjEtMy4yIDAtMS4zLS40LTIuNC0xLjEtMy4yLS44LS44LTEuOC0xLjItMy4yLTEuMnMtMi40LjQtMy4yIDEuMmMtLjguOC0xLjEgMS45LTEuMSAzLjJ6bTE3LjEtMTguM2g1LjR2MjdoLTUuNHYtMjd6bTI1LjYgMjRjLS45IDEuMS0xLjkgMS45LTMuMiAyLjUtMS4zLjYtMi43LjktNC4xLjktMS4zIDAtMi42LS4yLTMuOC0uNi0xLjItLjQtMi4yLTEtMy4xLTEuOC0uOS0uOC0xLjYtMS44LTIuMS0yLjlzLS43LTIuNC0uNy0zLjdjMC0xLjQuMi0yLjYuNy0zLjdzMS4yLTIuMSAyLjEtMi45Yy45LS44IDEuOS0xLjQgMy4xLTEuOHMyLjQtLjYgMy44LS42YzEuMiAwIDIuNC4yIDMuNC42czEuOSAxIDIuNiAxLjggMS4yIDEuOCAxLjYgMi45LjYgMi40LjYgMy43djEuN0gyNTZjLjIgMSAuNyAxLjggMS40IDIuNC43LjYgMS42LjkgMi42LjkuOSAwIDEuNi0uMiAyLjItLjZzMS4xLS45IDEuNi0xLjVsMy43IDIuN3ptLTQuNS03LjdjMC0uOS0uMy0xLjctLjktMi4zLS42LS42LTEuNC0xLTIuNC0xLS42IDAtMS4xLjEtMS42LjMtLjUuMi0uOC40LTEuMi43LS4zLjMtLjYuNi0uNyAxLS4yLjQtLjMuOC0uMyAxLjJoNy4xdi4xem0zMC45LTIuNGgtNC43djUuOGMwIC41IDAgLjkuMSAxLjMgMCAuNC4yLjcuMyAxIC4yLjMuNC41LjguNy4zLjIuOC4yIDEuNC4yLjMgMCAuNyAwIDEuMS0uMS41LS4xLjgtLjIgMS4xLS40djQuNWMtLjYuMi0xLjIuNC0xLjkuNC0uNi4xLTEuMy4xLTEuOS4xLS45IDAtMS43LS4xLTIuNS0uMy0uOC0uMi0xLjQtLjUtMi0uOXMtMS0xLTEuMy0xLjZjLS4zLS43LS41LTEuNS0uNS0yLjR2LTguMmgtMy40Vjk5aDMuNHYtNS4xaDUuNFY5OWg0Ljd2NC4yaC0uMXptMTkuMiAxMC4xYy0uOSAxLjEtMS45IDEuOS0zLjIgMi41LTEuMy42LTIuNy45LTQuMS45LTEuMyAwLTIuNi0uMi0zLjgtLjYtMS4yLS40LTIuMi0xLTMuMS0xLjhzLTEuNi0xLjgtMi4xLTIuOS0uNy0yLjQtLjctMy43YzAtMS40LjItMi42LjctMy43czEuMi0yLjEgMi4xLTIuOSAxLjktMS40IDMuMS0xLjggMi40LS42IDMuOC0uNmMxLjIgMCAyLjQuMiAzLjQuNnMxLjkgMSAyLjYgMS44IDEuMiAxLjggMS42IDIuOS42IDIuNC42IDMuN3YxLjdoLTEyLjRjLjIgMSAuNyAxLjggMS40IDIuNC43LjYgMS42LjkgMi42LjkuOSAwIDEuNi0uMiAyLjItLjZzMS4xLS45IDEuNi0xLjVsMy43IDIuN3ptLTQuNi03LjdjMC0uOS0uMy0xLjctLjktMi4zLS42LS42LTEuNC0xLTIuNC0xLS42IDAtMS4xLjEtMS42LjMtLjUuMi0uOC40LTEuMi43LS4zLjMtLjYuNi0uNyAxLS4yLjQtLjMuOC0uMyAxLjJoNy4xdi4xem0xMy4zIDEuNGwtNS44LTguMWg2LjNsMy4xIDQuNyAzLTQuN2g2bC01LjYgOC4xIDYuNyA5LjNIMzI5bC0zLjgtNS44LTQuMSA1LjhIMzE1bDYuOC05LjN6bTI3LTMuOGgtNC43djUuOGMwIC41IDAgLjkuMSAxLjMgMCAuNC4yLjcuMyAxIC4yLjMuNC41LjguNy4zLjIuOC4yIDEuNC4yLjMgMCAuNyAwIDEuMS0uMS41LS4xLjgtLjIgMS4xLS40djQuNWMtLjYuMi0xLjIuNC0xLjkuNC0uNi4xLTEuMy4xLTEuOS4xLS45IDAtMS43LS4xLTIuNS0uMy0uOC0uMi0xLjQtLjUtMi0uOXMtMS0xLTEuMy0xLjZjLS4zLS43LS41LTEuNS0uNS0yLjR2LTguMmgtMy40Vjk5aDMuNHYtNS4xaDUuNFY5OWg0Ljd2NC4yaC0uMXoiIGZpbGw9IiNmZmYiLz48L3N2Zz4=";

        // Default button
        $promos['buttons']['default'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['default'] as $key => $item) {
            $promos['buttons']['default'][$key]['excerpt'] = '';
        };

        // Default button with green gradient bg
        $promos['buttons']['default_gradient'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['default_gradient'] as $key => $item) {
            $promos['buttons']['default_gradient'][$key]['option'] = 'Bg gradient green';
            $promos['buttons']['default_gradient'][$key]['excerpt'] = '';
        };

        // Grey button with two lines
        $promos['buttons']['two_line_grey'] = app('Factories\UnderMenu')->create(4);

        // Green gradient button with two lines
        $promos['buttons']['two_line_gradient'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['two_line_gradient'] as $key => $item) {
            $promos['buttons']['two_line_gradient'][$key]['option'] = 'Bg gradient green';
        };

        // Icon light one line
        $promos['buttons']['icon_light'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['icon_light'] as $key => $item) {
            $promos['buttons']['icon_light'][$key]['option'] = 'Icon dark';
            $promos['buttons']['icon_light'][$key]['secondary_relative_url'] = $icon_light;
        };

        // Icon dark one line
        $promos['buttons']['icon_dark'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['icon_dark'] as $key => $item) {
            $promos['buttons']['icon_dark'][$key]['option'] = 'Icon dark';
            $promos['buttons']['icon_dark'][$key]['secondary_relative_url'] = $icon_dark;
        };

        // Icon light two lines
        $promos['buttons']['icon_light'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['icon_light'] as $key => $item) {
            $promos['buttons']['icon_light'][$key]['option'] = 'Icon light';
            $promos['buttons']['icon_light'][$key]['secondary_relative_url'] = $icon_light;
        };

        // Icon dark two lines
        $promos['buttons']['icon_dark'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['icon_dark'] as $key => $item) {
            $promos['buttons']['icon_dark'][$key]['option'] = 'Icon dark';
            $promos['buttons']['icon_dark'][$key]['secondary_relative_url'] = $icon_dark;
        };

        // Icon light with background image
        $promos['buttons']['icon_light_bg_img'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['icon_light_bg_img'] as $key => $item) {
            $promos['buttons']['icon_light_bg_img'][$key]['option'] = 'Icon light w/ img bg';
            $promos['buttons']['icon_light_bg_img'][$key]['relative_url'] = $bg_light;
            $promos['buttons']['icon_light_bg_img'][$key]['secondary_relative_url'] = $icon_light;
            $promos['buttons']['icon_light_bg_img'][$key]['excerpt'] = '';
        };

        // Icon dark with background image
        $promos['buttons']['icon_dark_bg_img'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['icon_dark_bg_img'] as $key => $item) {
            $promos['buttons']['icon_dark_bg_img'][$key]['option'] = 'Icon dark w/ img bg';
            $promos['buttons']['icon_dark_bg_img'][$key]['relative_url'] = $bg_dark;
            $promos['buttons']['icon_dark_bg_img'][$key]['secondary_relative_url'] = $icon_dark;
            $promos['buttons']['icon_dark_bg_img'][$key]['excerpt'] = '';
        };

        // Bg image light
        $promos['buttons']['bg_image_light'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['bg_image_light'] as $key => $item) {
            $promos['buttons']['bg_image_light'][$key]['option'] = 'Bg image light';
            $promos['buttons']['bg_image_light'][$key]['relative_url'] = $bg_light;
            $promos['buttons']['bg_image_light'][$key]['secondary_relative_url'] = $icon_light;
            $promos['buttons']['bg_image_light'][$key]['excerpt'] = '';
        };

        // Bg image dark
        $promos['buttons']['bg_image_dark'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['bg_image_dark'] as $key => $item) {
            $promos['buttons']['bg_image_dark'][$key]['option'] = 'Bg image dark';
            $promos['buttons']['bg_image_dark'][$key]['relative_url'] = $bg_dark;
            $promos['buttons']['bg_image_dark'][$key]['secondary_relative_url'] = $icon_dark;
            $promos['buttons']['bg_image_dark'][$key]['excerpt'] = '';
        };

        // SVG overlay light
        $promos['buttons']['bg_image_light'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['bg_image_light'] as $key => $item) {
            $promos['buttons']['bg_image_light'][$key]['option'] = 'SVG overlay light';
            $promos['buttons']['bg_image_light'][$key]['relative_url'] = $bg_light;
            $promos['buttons']['bg_image_light'][$key]['secondary_relative_url'] = $svg_light;
            $promos['buttons']['bg_image_light'][$key]['excerpt'] = '';
        };

        // SVG overlay dark
        $promos['buttons']['bg_image_dark'] = app('Factories\UnderMenu')->create(4);
        foreach ($promos['buttons']['bg_image_dark'] as $key => $item) {
            $promos['buttons']['bg_image_dark'][$key]['option'] = 'SVG overlay dark';
            $promos['buttons']['bg_image_dark'][$key]['relative_url'] = $bg_dark;
            $promos['buttons']['bg_image_dark'][$key]['secondary_relative_url'] = $svg_dark;
            $promos['buttons']['bg_image_dark'][$key]['excerpt'] = '';
        };

        return view('styleguide-under-menu', merge($request->data, $promos));
    }
}
