import math

def distance_between_points(pointA, pointB):
    return calculate_hypotenuse((pointA['x'] - pointB['x']), (pointA['y'] - pointB['y']))

def calculate_hypotenuse(opposite_leg, adjacent_leg):
    return math.sqrt(opposite_leg**2 + adjacent_leg**2)

def herons_formule(s, a, b, c):
    return math.sqrt(s * (s - a) * (s - b) * (s - c))

def law_of_cosines(sideA, sideB, sideC):
    return (sideA**2 + sideB**2 - sideC**2)/(2 * sideA * sideB)

def is_right_angle(angle):
    return angle == math.pi/2

def is_acute(angle):
    return angle < math.pi/2

def is_obtuse(angle):
    return angle > math.pi/2
    