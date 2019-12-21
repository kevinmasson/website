---
title: "Propagate shortcuts — key inputs — from dialogs to Maya with Qt"
date: 2018-01-09T21:37:43+01:00
draft: true
---

If you want to use Maya or any other application's shortcuts while you are using a custom tool, you need to propagate key events to the application. It can be useful with custom Qt dialogs and widgets.

To propagate a key event, you just need to ignore it in your widget or window.

```python
class YourWidget(QtGui.QWidget):
    ....

    def keyPressEvent(self, event):
        if ... :
            event.accept()
        else:
            event.ignore()
```

By default, the event is accepted, so accepting is useless. And don't call the base class's implementation after you ignore the event. Your actions will have no effect.

When you ignore an event, it will be transferred to the parent until a widget accepts it.

You can also disable keyboard focus on your widget.

```python
self.setFocusPolicy(QtCore.Qt.ClickFocus)  # or Qt.NoFocus
```

See [setFocusPolicy](https://srinikom.github.io/pyside-docs/PySide/QtGui/QWidget.html#PySide.QtGui.PySide.QtGui.QWidget.setFocusPolicy) and [QKeyEvent](https://srinikom.github.io/pyside-docs/PySide/QtGui/QKeyEvent.html#PySide.QtGui.QKeyEvent) for more details.

