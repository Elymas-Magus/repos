import math
import Helper

class Triangle:
    def __init__(self):
        self.pointA = None
        self.pointB = None
        self.pointC = None
        
        self.sideAB = None
        self.sideAC = None
        self.sideBC = None
        
        self.angleABC = None
        self.angleACB = None
        self.angleBAC = None
        
        self.isEquilateral = None
        self.isIsosceles = None
        self.isScalene = None
        self.isRectangle = None
        self.isAcutangle = None
        self.isObtuseangle = None
        
        self.orderedSides = []
        self.hasError = False
        
        self.perimeter = None
        self.area = None
            
            
    def create(self, pointA = None, pointB = None, pointC = None):
        self.pointA = pointA
        self.pointB = pointB
        self.pointC = pointC
        
        self.setSideAB()
        self.setSideAC()
        self.setSideBC()
        
        self.setAngleABC()
        self.setAngleACB()
        self.setAngleBAC()
        
        self.checkIfIsValidAndOrder()
        
        if self.hasError:
            return None
        
        self.setTriangleType()
        
        self.setPerimeter()
        self.setArea()
        
    def setSideAB(self):
        self.sideAB = Helper.distance_between_points(self.pointA, self.pointB)
        
    def setSideAC(self):
        self.sideAC = Helper.distance_between_points(self.pointA, self.pointC)
        
    def setSideBC(self):
        self.sideBC = Helper.distance_between_points(self.pointB, self.pointC)
        
    def initTriangleTypesAttributes(self):
        self.isEquilateral = False
        self.isIsosceles = False
        self.isScalene = False
        
    def setTriangleType(self):
        self.initTriangleTypesAttributes()
        
        if self.sideAB == self.sideAC and self.sideAB == self.sideBC:
            self.isEquilateral = True
        elif self.sideAB == self.sideAC:
            self.isIsosceles = True
        elif self.sideAB == self.sideBC:
            self.isIsosceles = True
        elif self.sideAC == self.sideBC:
            self.isIsosceles = True
        else:
            self.isScalene = True
            
        self.isRectangle = bool(len(list(filter(Helper.is_right_angle, self.orderedAngles))))
        self.isAcutangle = len(list(filter(Helper.is_acute, self.orderedAngles))) == 3
        self.isObtuseangle = bool(len(list(filter(Helper.is_obtuse, self.orderedAngles))))
        # self.isObtuseangle = not self.isRectangle and not self.isAcutangle
        
    def checkIfIsValidAndOrder(self):
        self.orderedSides = [self.sideAB, self.sideAC, self.sideBC]
        self.orderedAngles = [self.angleABC, self.angleACB, self.angleBAC]
        
        self.orderedSides.sort()
        self.orderedAngles.sort()
        
        self.hasError = not self.is_valid_triangle(self.orderedSides[2], self.orderedSides[1], self.orderedSides[0])
        
    @staticmethod
    def is_valid_triangle(biggestSide, side1, side2):
        return biggestSide < side1 + side2        
        
    def setAngleABC(self):
        self.angleABC = math.acos(Helper.law_of_cosines(self.sideBC, self.sideAB, self.sideAC))
        
    def setAngleBAC(self):
        self.angleBAC = math.acos(Helper.law_of_cosines(self.sideAC, self.sideAB, self.sideBC))
        
    def setAngleACB(self):
        self.angleACB = math.acos(Helper.law_of_cosines(self.sideBC, self.sideAC, self.sideAB))
        
    def setPerimeter(self):
        self.perimeter = self.calculate_perimeter()
        
    def setArea(self):
        self.area = self.calculate_area()
        
    def calculate_perimeter(self):
        return self.sideAB + self.sideAC + self.sideBC
        
    def calculate_area(self):
        return Helper.herons_formule(self.perimeter / 2, self.sideAB, self.sideAC, self.sideBC)
    
    def getTriangleType(self):
        if self.isEquilateral:
            return "Equilatero"
        elif self.isIsosceles:
            return "Isósceles"
        elif self.isScalene:
            return "Escaleno"
    
    def getTriangleAngleType(self):
        if self.isRectangle:
            return "Retângulo"
        elif self.isAcutangle:
            return "Acutângulo"
        elif self.isObtuseangle:
            return "Obtusângulo"
        
    def getSideAB(self):
        return self.sideAB
        
    def getSideAC(self):
        return self.sideAC
        
    def getSideBC(self):
        return self.sideBC
        
    def getAngleABC(self):
        return math.degrees(self.angleABC)
        
    def getAngleACB(self):
        return math.degrees(self.angleACB)
        
    def getAngleBAC(self):
        return math.degrees(self.angleBAC)
    
    def getPerimeter(self):
        return self.perimeter
    
    def getArea(self):
        return self.area