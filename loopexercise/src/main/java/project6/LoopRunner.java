package project6;
import java.util.Scanner;

/**
 *
 * @author ccronk
 */
public class LoopRunner {

    public static void main(String[] args) {
        Scanner in = new Scanner(System.in);
        
        System.out.println("Please enter your first name:");
        String name = in.next();
        int nameLength = name.length();
        
        for(int ii = nameLength - 1; ii >= 0; ii--) //goes backwards through the name
        { //ii is start point for substring, so ii+1 is end point
            String letter = name.substring(ii,ii+1);
            System.out.print(letter);
        }
        
        System.out.print("\n");
        System.out.println("\n-----------------------------------\n");
        
        System.out.println("Please enter a positive integer:");
        int n = in.nextInt();
        String symbolToPrint = "*";
        String blankToPrint = " ";
        
    //empty "square"
        for(int rowNumber = 1;rowNumber <= n;rowNumber++) //for n number of rows
        {
            if(rowNumber == 1 || rowNumber == n) //if first or last row, print symbols equal to n
            {
                for(int symbolNumber = 1; symbolNumber <= n;symbolNumber++)
                {
                    System.out.print(symbolToPrint);
                }
            }
            else //if a middle line
            {
                for(int symbolNumber = 1; symbolNumber <= n; symbolNumber++)
                {
                    if(symbolNumber == 1 || symbolNumber == n) //if start or end of row print symbol
                    {
                        System.out.print(symbolToPrint);
                    }
                    else //else print blank
                    {
                        System.out.print(blankToPrint);
                    }
                }
            }
            System.out.print("\n"); //starts new row
        }
        System.out.print("\n"); //break between shapes
        
    //"square" with slash
        for(int rowNumber = 1;rowNumber <= n;rowNumber++) //for n number of rows
        {
            if(rowNumber == 1 || rowNumber == n) //if first or last row, print symbols equal to n
            {
                for(int symbolNumber = 1; symbolNumber <= n;symbolNumber++)
                {
                    System.out.print(symbolToPrint);
                }
            }
            else //if a middle line
            {
                for(int symbolNumber = 1; symbolNumber <= n; symbolNumber++)
                {
                    if(symbolNumber == 1 || symbolNumber == n || symbolNumber == rowNumber) //if start, end, or row number of row, print symbol
                    {
                        System.out.print(symbolToPrint);
                    }
                    else //else print blank
                    {
                        System.out.print(blankToPrint);
                    }
                }
            }
            System.out.print("\n"); //starts new row
        }
        System.out.print("\n"); //break between shapes
        
    //hourglass
        for(int rowNumber = 1;rowNumber <= n;rowNumber++) //for n number of rows
        {
            if(rowNumber == 1 || rowNumber == n) //if first or last row, print symbols equal to n
            {
                for(int symbolNumber = 1; symbolNumber <= n;symbolNumber++)
                {
                    System.out.print(symbolToPrint);
                }
            }
            else //if a middle row
            {
                for(int symbolNumber = 1; symbolNumber <= n; symbolNumber++)
                {
                    if(symbolNumber == rowNumber || symbolNumber == n + 1 - rowNumber) //if row number (diagonal one) or max plus 1 minus row number (diagonal two)...
                    { //print symbol
                        System.out.print(symbolToPrint);
                    }
                    else //else print blank
                    {
                        System.out.print(blankToPrint);
                    }
                }
            }
            System.out.print("\n"); //starts new row
        }
    }
}
