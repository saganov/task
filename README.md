PHP Test Task
=============

Need to create an application which will generate HTML page with grid depending on
given configuration.

Grid with cells could be presented as following:

+-----------+
| 1 | 2 | 3 |
+---+---+---+
| 4 | 5 | 6 |
+---+---+---+
| 7 | 8 | 9 |
+---+---+---+

Configuration array allows to set rectangles which use certain cells with optional text,
font color, background color, horizontal and vertical alignment.
Same cells could not be used by more than one rectangle.
Amount of possible rectangles at grid is restricted only by available space.
Images usage is not allowed.

Requirements and preferences:
1) Validation is required.
2) Logic has to be separated from templates. (hardcode is unacceptable)
3) OOP approach is required.
4) It will be a plus if you follow SOLID principles.
