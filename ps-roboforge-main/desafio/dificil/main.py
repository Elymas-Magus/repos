from math import *
from GeometriaPlana import Triangle

def treatedInput(label):
    coordinates = input(label).replace("(", "").replace(")", "").replace(" ", "").split(",")
    
    return {
        'x': int(coordinates[0]),
        'y': int(coordinates[1]),
    }

def main():
    triangle = Triangle()
    
    pointA = treatedInput("Entre com as coordenadas do ponto A (X, Y):  ")
    pointB = treatedInput("Entre com as coordenadas do ponto B (X, Y):  ")
    pointC = treatedInput("Entre com as coordenadas do ponto C (X, Y):  ")
    
    # pointA = {'x': 0, 'y': 0}
    # pointB = {'x': 3, 'y': sqrt(27)}
    # pointC = {'x': 6, 'y': 0}
    
    triangle.create(pointA, pointB, pointC)
    
    print("Lados do triangulo")
    print("Lado AB: {}".format(triangle.getSideAB()))
    print("Lado AC: {}".format(triangle.getSideAC()))
    print("Lado BC: {}\n".format(triangle.getSideBC()))
    
    print("Angulos do triangulo")
    print("Angulo ABC: {}".format(triangle.getAngleABC()))
    print("Angulo ACB: {}".format(triangle.getAngleACB()))
    print("Angulo BAC: {}\n".format(triangle.getAngleBAC()))
    
    print("Perimetro: {}".format(triangle.getPerimeter()))
    print("Area: {}\n".format(triangle.getArea()))
    
    print("Este triângulo é {} e {}".format(triangle.getTriangleType(), triangle.getTriangleAngleType()))
    
main()